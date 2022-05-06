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
use Illuminate\Support\Facades\DB;

class MohCampaignController extends Controller {
    public function index(Request $request) {
        $cities = City::all();

        $campaigns = Campaign::query();

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

        if ($request->has('search') && $request->search) {
            $campaigns = $campaigns->where('address', 'like', '%' . $request->search . '%');
        }

        if ($request->has('start_date') && $request->start_date && $request->has('end_date') && $request->end_date) {
            $campaigns = $campaigns->where('start_date', '>=', $request->start_date)->where('end_date', '<=', $request->end_date);
        }

        if ($request->has('city') && $request->city) {
            $campaigns = $campaigns->where('city', $request->city);
        }

        return view('moh.manage-campaigns')
            ->with('campaigns', $campaigns->paginate(10)->withQueryString())
            ->with('cities', $cities);
    }

    public function create(Request $request) {
        $request->validate([
            'start_date' => 'required|date|after:yesterday',
            'end_date' => 'required|date|after:start_date',
            'capacity_per_day' => 'required|integer|min:1',
            'city' => 'required|string',
            'address' => 'required|string'
        ]);


        $campaign = Campaign::create([
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'location'          => preg_replace(array('/\(/', '/\)/'), array('', ''), $request->location),
            'city'              => $request->city,
            'address'           => $request->address,
            'capacity_per_day'  => $request->capacity_per_day,
            'status'            => now() >= $request->start_date ? 'active' : 'pending'
        ]);

        return back()->with('message', 'Campaign added successfully');
    }

    public function delete(Campaign $campaign) {
        if (now()->diffInDays($campaign->start_date) < 1) {
            return back()->with('message', 'Can\'t cancel a campaign that is starting in two days !');
        }

        $campaign->update([
            'status'    =>  'cancelled'
        ]);

        DB::table('campaign_appointments')
            ->where('campaign_id', $campaign->id)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'finished')
            ->update([
                'status'    =>  'cancelled'
            ]);

        return back()->with('message', 'Campaign cancelled successfully');
    }
    
    public function update(Request $request, Campaign $campaign) {
        if (now()->diffInDays($campaign->start_date) < 1) {
            return back()->with('message', 'Can\'t update a campaign that is starting in two days !');
        }

        $request->validate([
            'start_date' => 'required|date|after:yesterday',
            'end_date' => 'required|date|after:start_date',
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
            'status'            => now() >= $request->start_date ? 'active' : 'pending'
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
