<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;

class ReseservationController extends Controller
{
    public function index(Request $request) {
        if (
            $request->user()->telephone_number != null &&
            $request->user()->birthdate != null &&
            $request->user()->address != null &&
            $request->user()->phones->count() > 0
        ) {
            return redirect('/reserve/step2');
        }

        return view('citizen.reservation1');
    }

    public function store(Request $request) {
        $request->validate([
            'address' => 'required|string',
            'telephone_number' => 'required',
            'birthdate' => 'required',
            'gender' => 'required'
        ]);

        $gender = ($request->gender === 'Male') ? 'Male' : 'Female';

        $request->user()->update([
            'address'           =>  $request->address,
            'telephone_number'  =>  $request->telephone_number,
            'birthdate'         =>  $request->birthdate,
            'gender'            =>  $gender
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

    public function campaigns(Request $request) {
        if (
            $request->user()->telephone_number != null &&
            $request->user()->birthdate != null &&
            $request->user()->address != null &&
            $request->user()->phones->count() > 0
        ) {
            $campaigns = Campaign::where('end_date', '>', now())->get();

            return view('citizen.reservation2')->with('campaigns', $campaigns);
        }

        return redirect('/reserve');
    }

    public function reserve(Request $request, Campaign $campaign) {
        if ($campaign->end_date < now()) {
            return back()->withErrors([
                'campaign' => 'Campaign has ended'
            ]);
        }

        $date = rand(strtotime($campaign->start_date), strtotime($campaign->end_date));

        $request->user()->reservations()->attach($campaign->id, ['date' =>  date('Y-m-d H:i:s', $date)]);

        return view('citizen.reservecomplete');
    }
}
