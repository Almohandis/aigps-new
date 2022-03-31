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
use App\Models\City;

class MohCampaignController extends Controller {
    //# Get all campaigns
    public function index(Request $request) {
        $cities = City::all();

        $campaigns = Campaign::query();

        // filter by ascending address

        if ($request->has('sort') && $request->sort) {
            $campaigns = $campaigns->orderBy($request->sort, $request->order == 'asc' ? 'asc' : 'desc');
        }


        if ($request->has('status') && $request->status) {
            if ($request->status == 'active') {
                $campaigns = $campaigns->where('status', 'active');
            } else {
                $campaigns = $campaigns->where('status', '!=', 'active');
            }
        }

        if ($request->has('city') && $request->city) {
            $campaigns = $campaigns->where('city', $request->city);
        }

        return view('moh.manage-campaigns')
            ->with('campaigns', $campaigns->paginate(10)->withQueryString())
            ->with('cities', $cities);
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

    public function delete(Campaign $campaign) {
        if (now()->diffInDays($campaign->start_date) < 1) {
            return back()->with('message', 'Can\'t cancel a campaign that is starting in two days !');
        }

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
        $cities = City::all();

        if (now()->diffInDays($campaign->start_date) < 1) {
            return back()->with('message', 'Can\'t update a campaign that is starting in two days !');
        }

        return view('moh.update-campaign')
            ->with('campaign', $campaign->load('doctors'))
            ->with('cities', $cities);
    }

    public function removeDoctor(Request $request, Campaign $campaign, User $doctor) {
        $campaign->doctors()->detach($doctor->id);
        return back()->with('message', 'Doctor removed successfully');
    }

    public function addDoctor(Request $request, Campaign $campaign) {
        $request->validate([
            'national_id' => 'required'
        ]);

        $doctor = User::where('national_id', $request->national_id)->first();

        if (!$doctor) {
            return back()->with('message', 'Doctor with ID ' . $request->national_id . ' does not exist');
        }

        if ($campaign->doctors()->where('user_id', $doctor->id)->first()) {
            return back()->with('message', 'Doctor with ID ' . $request->national_id . ' is already assigned to this campaign');
        }

        $campaign->doctors()->attach($doctor->id);

        return back()->with('message', 'Doctor Added successfully');
    }
}
