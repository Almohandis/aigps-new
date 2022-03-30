<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Jobs\InfectionNotificationJob;
use App\Models\MedicalPassport;

class CampaignClerkController extends Controller
{
    public function index() {
        $cities = ['6th of October', 'Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];

        return view('clerk.clerk')
            ->with('cities', $cities)
            ->with('countries', \Countries::getList('en'));
    }

    public function store(Request $request) {
        $request->validate([
            'national_id' => 'required|string|max:255',
            'blood_type' => 'required|string|max:3',
            'city'      =>      'required|string'
        ]);

        $user = User::where('national_id', $request->national_id)->first();

        if (!$user) {
            return back()->withErrors(['national_id' => 'User not found']);
        }

        $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        if (!in_array($request->blood_type, $blood_types)) {
            return back()->withErrors(['blood_type' => 'Invalid blood type']);
        }

        //# increase dose count if patient already has been diagnosed because they have just taken vaccination
        if ($user->is_diagnosed) {
            $user->passport()->update([
                'vaccine_dose_count' => $user->passport->vaccine_dose_count + 1,
                'vaccine_name' => $request->vaccine_name,
            ]);

            $date = $user->passport()->first()->dates()->create([
                'vaccine_date' => now(),
            ]);
        }

        $user->update([
            'blood_type'    => $request->blood_type,
            'is_diagnosed'  => $request->is_diagnosed == 'true' ? true : ($user->is_diagnosed ? true : false),
            'city'          => $request->city
        ]);
        // return $request;
        $disease = 1;
        while (1) {
            $disease_name = $request->input('disease' . $disease);
            // return $disease_name;
            if (!$disease_name) {
                break;
            }

            $user->diseases()->create([
                'name' => $disease_name
            ]);

            $disease++;
        }

        if ($request->input('infection')) {
            $user->infections()->create([
                'infection_date'  => $request->infection
            ]);

            InfectionNotificationJob::dispatch($user);
        }

        if ($request->input('is_recovered') == 'true') {
            $user->infections()->update([
                'is_recovered'      =>  true,
            ]);
        }

        return back()->withSuccess('User updated successfully');
    }
}
