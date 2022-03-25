<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Campaign;
use App\Models\Hospital;
use App\Models\User;
use Symfony\Contracts\Service\Attribute\Required;
use \Carbon\Carbon;

class MohCampaignController extends Controller {
    //# Get all campaigns
    public function index(Request $request) {
        $campaigns = Campaign::get();
        return view('moh.manage-campaigns')->with('campaigns', $campaigns);
    }

    //# Add new campaign
    public function create(Request $request) {
        if ($request->end_date < $request->start_date)
            return back()->with('message', 'End date cannot be before start date');
        if (!$request->location)
            return back()->with('message', 'Please select a location');


        //# Check if doctors with given IDs exist
        if ($request->doctors) {
            foreach ($request->doctors as $doctor) {
                $user = User::where('national_id', $doctor)->first();
                if (!$user)
                    return back()->with('message', 'Doctor with ID ' . $doctor . ' does not exist');

                //# Check if doctor is already working in a campaign
                if ($user->campaigns()->first()) {
                    $busy_doctor = $user->campaigns()->where('start_date', '>', now())->first();
                    $unavailable_doctor = $user->campaigns()->where('end_date', '>', now())->first();
                    if ($busy_doctor || $unavailable_doctor)
                        return back()->with('message', 'Doctor with ID ' . $doctor . ' is already assigned to a campaign');
                }
            }
        }


        //# Create new campaign
        $campaign = Campaign::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => preg_replace(array('/\(/', '/\)/'), array('', ''), $request->location),
            'city' => $request->city,
            'address' => $request->address,
            'capacity_per_day' => $request->capacity_per_day ?? 20,
        ]);

        //# Assign doctors to campaign
        if ($request->doctors) {
            foreach ($request->doctors as $doctor) {
                $doctor_id = User::where('national_id', $doctor)->first()->id;
                $campaign->doctors()->attach($doctor_id, ['from' => $request->start_date, 'to' => $request->end_date]);
            }
        }

        if ($campaign)
            return back()->with('message', 'Campaign added successfully');
        else
            return back()->with('message', 'Campaign could not be added');
    }

    public function cancel(Campaign $campaign) {
        if (now()->diffInDays($campaign->start_date) < 1) {
            return back()->with('message', 'Can\'t cancel a campaign that is starting in two days !');
        }

        $campaign->appointments()->update(['campaign_appointments.status' => 'cancelled']);
        $campaign->delete();

        //TODO: we should probably notify the user that their campaign has been cancelled

        return back()->with('message', 'Campaign cancelled successfully');
    }
    
    public function update(Request $request, Campaign $campaign) {
        if (now()->diffInDays($campaign->start_date) < 1) {
            return back()->with('message', 'Can\'t update a campaign that is starting in two days !');
        }

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'location' => 'required',
            'city' => 'required',
            'address' => 'required',
            'capacity_per_day' => ['required', 'numeric', 'min:1'],
        ]);

        $campaign->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'city' => $request->city,
            'address' => $request->address,
            'capacity_per_day' => $request->capacity_per_day,
        ]);

        return redirect('/staff/moh/manage-campaigns')->with('message', 'Campaign updated successfully');
    }

    public function updateView(Request $request, Campaign $campaign) {
        $cities = ['6th of October', 'Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];

        if (now()->diffInDays($campaign->start_date) < 1) {
            return back()->with('message', 'Can\'t update a campaign that is starting in two days !');
        }

        return view('moh.update-campaign')
            ->with('campaign', $campaign)
            ->with('cities', $cities);
    }
}
