<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Jobs\InfectionNotificationJob;
use App\Models\MedicalPassport;
use App\Models\VaccineDate;

class CampaignClerkController extends Controller
{
    public function index(Request $request)
    {
        $campaign = $request->user()
            ->campaigns()
            ->where('campaign_doctors.from', '<=', now())
            ->where('campaign_doctors.to', '>=', now())
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('status', 'active')
            ->first();


        if (!$campaign) {
            return view('clerk.clerk')->withErrors([
                'campaign'  =>  'Your account is not associated with any campaign'
            ]);
        }

        $appointments = \DB::table('campaign_appointments')
            ->where('campaign_id', $campaign->id)
            ->where('date', '>=', now()->startOfDay())
            ->where('date', '<=', now()->endOfDay())
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'finished')
            ->join('users', 'users.id', '=', 'campaign_appointments.user_id')
            ->get();


        return view('clerk.clerk')->with('appointments', $appointments);
    }

    public function find(Request $request)
    {
        $request->validate([
            'national_id' => 'required|string|max:255'
        ]);

        $user = User::with('infections')->with('diseases')->where('national_id', $request->national_id)->first();

        if (!$user) {
            return back()->withErrors(['national_id' => 'User not found']);
        }

        $campaigns = $request->user()
            ->campaigns()
            ->where('campaign_doctors.from', '<=', now())
            ->where('campaign_doctors.to', '>=', now())
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('status', 'active')
            ->get();

        if (count($campaigns) == 0) {
            return back()->withErrors(['campaign' => 'You are not a doctor of any active campaigns']);
        }

        $reservation = $user->reservations()
            ->whereIn('campaign_appointments.campaign_id', $campaigns->pluck('id'))
            ->where('campaign_appointments.date', '>', now()->subDays(1))
            ->where('campaign_appointments.date', '<', now()->addDays(1))
            ->where('campaign_appointments.status', '!=', 'cancelled')
            ->where('campaign_appointments.status', '!=', 'finished')
            ->first();

        if (!$reservation) {
            return back()->withErrors(['reservation' => 'This user is not a registered in this campaign, or the date of his reservation is not today']);
        }

        $medicalPassport = $user->passport()->where('user_id', $user->id)->first();
        $vaccines = [];

        if ($medicalPassport) {
            $vaccines = VaccineDate::where('medical_passport_id', $medicalPassport->id)->get();
        } else {
            $medicalPassport = new MedicalPassport();
            $medicalPassport->user_id = $user->id;
            $medicalPassport->vaccine_dose_count = 0;
            $medicalPassport->save();
        }

        return view('clerk.user')
            ->with('user', $user)
            ->with('reservation', $reservation)
            ->with('campaigns', $campaigns)
            ->with('vaccines', $vaccines)
            ->with('passport', $medicalPassport);
    }

    public function complete(Request $request, User $user)
    {
        $campaigns = $request->user()
            ->campaigns()
            ->where('campaign_doctors.from', '<=', now())
            ->where('campaign_doctors.to', '>=', now())
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('status', 'active')
            ->get();

        if (count($campaigns) == 0) {
            return back()->withErrors(['campaign' => 'You are not a doctor of any active campaigns']);
        }


        $reservation = $user->reservations()
            ->whereIn('campaign_appointments.campaign_id', $campaigns->pluck('id'))
            ->where('campaign_appointments.date', '>', now()->subDays(1))
            ->where('campaign_appointments.date', '<', now()->addDays(1))
            ->where('campaign_appointments.status', '!=', 'cancelled')
            ->where('campaign_appointments.status', '!=', 'finished')
            ->first();

        if (!$reservation) {
            return back()->withErrors(['reservation' => 'This user is not a registered in this campaign, or the date of his reservation is not today']);
        }

        $medicalPassport = $user->passport()->where('user_id', $user->id)->first();

        if ($request->has('blood_type') && $request->blood_type != '') {
            $user->blood_type = $request->blood_type;
        }

        $disease = 1;
        while ($disease < 10) {
            $disease_number = $request->input('disease' . $disease);
            if ($disease_number) {
                $user->diseases()->create([
                    'name'      =>      $disease_number
                ]);
            } else {
                break;
            }

            $disease++;
        }

        $reservation->pivot->status = 'finished';
        $reservation->pivot->save();

        if ($request->has('infection') && $request->infection != '') {
            $user->infections()->create([
                'infection_date'    =>  now(),
                'hospital_id'       =>  NULL,
                'is_recovered'      =>  false,
                'has_passed_away'   =>  $request->has('passed_away')
            ]);

            return redirect('/staff/clerk')->withSuccess('This user has been infected, and his data has been inserted into the database successfully !');
        } else {
            if ($request->has('vaccine_name') && $request->vaccine_name != '') {
                $medicalPassport->update([
                    'vaccine_name' => $request->vaccine_name,
                ]);

                $doseCount = $medicalPassport->vaccine_dose_count;
                $medicalPassport->update([
                    'vaccine_dose_count' => $doseCount < 2 ? $doseCount + 1 : $doseCount
                ]);

                VaccineDate::create([
                    'medical_passport_id'   => $medicalPassport->id,
                    'vaccine_date'          =>  now()
                ]);

                return redirect('/staff/clerk')->withSuccess('User has been vaccination successfully !');
            } else {
                $reservation->pivot->status = 'pending';
                $reservation->pivot->save();
                return back()->withErrors(['vaccine' => 'Please select a vaccine name']);
            }
        }
    }
}
