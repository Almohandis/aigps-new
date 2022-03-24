<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Campaign;
use App\Models\Hospital;
use App\Models\User;
use Symfony\Contracts\Service\Attribute\Required;

class MohCampaignController extends Controller {
    //# Get all campaigns
    public function manageCampaigns(Request $request) {
        $campaigns = Campaign::get();
        return view('moh.manage-campaigns')->with('campaigns', $campaigns);
    }

    //# Add new campaign
    public function addCampaign(Request $request) {
        if ($request->end_date < $request->start_date)
            return back()->with('message', 'End date cannot be before start date');
        if (!$request->location)
            return back()->with('message', 'Please select a location');


        //# Check if doctors with given IDs exist
        if ($request->doctors) {
            foreach ($request->doctors as $doctor) {
                $user = User::where('national_id', $doctor)->first();
                if (!$user)
                    return redirect('/staff/moh/manage-campaigns')->with('message', 'Doctor with ID ' . $doctor . ' does not exist');

                //# Check if doctor is already working in a campaign
                if ($user->campaigns()->first()) {
                    $busy_doctor = $user->campaigns()->where('start_date', '>', now())->first();
                    $unavailable_doctor = $user->campaigns()->where('end_date', '>', now())->first();
                    if ($busy_doctor || $unavailable_doctor)
                        return redirect('/staff/moh/manage-campaigns')->with('message', 'Doctor with ID ' . $doctor . ' is already assigned to a campaign');
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
            return redirect('/staff/moh/manage-campaigns')->with('message', 'Campaign added successfully');
        else
            return redirect('/staff/moh/manage-campaigns')->with('message', 'Campaign could not be added');
    }

    public function cancel(Campaign $campaign) {
        $campaign->appointments()->update(['campaign_appointments.status' => 'cancelled']);
        $campaign->delete();

        //TODO: we should probably notify the user that their campaign has been cancelled

        return redirect('/staff/moh/manage-campaigns')->with('message', 'Campaign cancelled successfully');
    }
}
