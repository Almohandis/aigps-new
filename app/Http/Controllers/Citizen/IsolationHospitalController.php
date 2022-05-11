<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\ReservationNotification;
use App\Models\City;
use App\Models\Hospital;
use Twilio;

class IsolationHospitalController extends Controller
{
    public function index(Request $request) {
        $hospitals = Hospital::where('is_isolation', true)->with('patients')->get();

        return view('citizen.isolation')->with([
			'hospitals' 		=> $hospitals,
			'message' 			=> '',
		]);
    }

    public function reserve(Request $request, Hospital $hospital) {
        $request->validate([
            'checkin_date' => 'required|date|after:yesterday',
        ]);

        $reservation = \DB::table('hospitalizations')->where('user_id', $request->user()->id)->where('checkout_date', NULL)->first();

        if ($reservation) {
            return back()->withErrors(['message' => 'You are already reserved in a hospital.']);
        }

        if (! $hospital->is_isolation) {
            return back()->withErrors(['message' => 'This hospital is not an isolation hospital.']);
        }

        if ($hospital->capacity <= count($hospital->patients)) {
            return back()->withErrors(['message' => 'Hospital is full']);
        }

        $hospital->patients()->attach($request->user()->id, [
            'checkin_date' => $request->checkin_date,
        ]);

        return back()->withSuccess('You have successfully reserved this hospital.');
    }
}
