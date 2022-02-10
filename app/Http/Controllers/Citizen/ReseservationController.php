<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;

class ReseservationController extends Controller
{
    public function index(Request $request) {
        $campaigns = Campaign::where('end_date', '>', now())->where('type', 'vaccination')->get();

        return view('citizen.reservation2')->with('campaigns', $campaigns);
    }

    public function reserve(Request $request, Campaign $campaign) {
        if ($campaign->end_date < now()) {
            return back()->withErrors([
                'campaign' => 'Campaign has ended'
            ]);
        }

        $start = max(strtotime($campaign->start_date), strtotime(today()));
        $end = strtotime($campaign->end_date);

        $date = rand($start, $end);

        $request->user()->reservations()->attach($campaign->id, ['date' =>  date('Y-m-d H:i:s', $date)]);

        if (
            $request->user()->telephone_number != null &&
            $request->user()->birthdate != null &&
            $request->user()->address != null &&
            $request->user()->gender != null &&
            $request->user()->country != null &&
            $request->user()->phones->count() > 0
        ) {
            return view('citizen.reservecomplete');
        }

        return redirect('/reserve/step2');
    }

    public function store(Request $request) {
        $request->validate([
            'address' => 'required|string',
            'telephone_number' => 'required',
            'birthdate' => 'required',
            'gender' => 'required',
            'country'   =>  'required|string'
        ]);

        $gender = ($request->gender === 'Male') ? 'Male' : 'Female';

        $request->user()->update([
            'address'           =>  $request->address,
            'telephone_number'  =>  $request->telephone_number,
            'birthdate'         =>  $request->birthdate,
            'gender'            =>  $gender,
            'country'           =>  $request->country
        ]);

        //# user can have multiple phones, up to 10
        $phone = 1;
        while($phone < 10) {
            $phone_number = $request->input('phone'.$phone);
            if ($phone_number) {
                $request->user()->phones()->create([
                    'phone_number' => $phone_number
                ]);
            } else {
                break;
            }

            $phone++;
        }

        return redirect('/reserve/step2');
    }

    public function form(Request $request) {
        if (
            $request->user()->telephone_number != null &&
            $request->user()->birthdate != null &&
            $request->user()->address != null &&
            $request->user()->gender != null &&
            $request->user()->country != null &&
            $request->user()->phones->count() > 0
        ) {
            return view('citizen.reservecomplete'); //#
        }

        return view('citizen.reservation1')->with([
            'countries'     =>      \Countries::getList('en')
        ]);
    }
}
