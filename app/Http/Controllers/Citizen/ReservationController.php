<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\ReservationNotification;
use App\Models\City;

class ReservationController extends Controller
{
    public function index(Request $request) {
        if (!$this->canReserve($request)) {
            return view('citizen.survey-error');
        }

        $campaigns = Campaign::where('end_date', '>', now())->where('status', 'active')->orderBy('start_date', 'asc')->get();

        //# capacity check
        foreach ($campaigns as $campaign) {
            $start = Carbon::parse($campaign->start_date);
            $end = Carbon::parse($campaign->end_date);
            $days = $start->diffInDays($end) + 1;

            if ($campaign->appointments()->count() >= $days * $campaign->capacity_per_day) {
                $campaigns->forget($campaign->id);
            } else {
                $campaign->capacity = $campaign->appointments()->count();
                $campaign->maxCapacity = $days * $campaign->capacity_per_day;
            }
        }

        return view('citizen.reservation')->with([
			'campaigns' 		=> $campaigns,
			'diagnosed'			=>	$request->user()->is_diagnosed,
			'message' 			=> $request->user()->is_diagnosed ? null : 'This will be a diagnose reservation.',
		]);
    }

    public function reserve(Request $request, Campaign $campaign) {
        if (!$this->canReserve($request)) {
            return view('citizen.survey-error');
        }

        if ($campaign->end_date < now()) {
            return back()->withErrors([
                'campaign' => 'Campaign has ended'
            ]);
        }

        if ($request->user()->reservations()->where('campaign_appointments.status', '!=', 'cancelled')->where('campaign_appointments.status', '!=', 'finished')->where('date', '>=', now())->count()) {
            return back()->withErrors([
                'campaign' => 'You have already reserved an appointment'
            ]);
        }

        $birthdate = Carbon::parse($request->user()->birthdate);

        if ($birthdate->diffInYears(now()) < 16 || $birthdate->diffInYears(now()) > 70) {
            return back()->withErrors([
                'campaign' => 'You have to be between 16 and 70 years old to reserve an appointment'
            ]);
        }

        $start = new Carbon($campaign->start_date);
        $end = new Carbon($campaign->end_date);
        $day = 0;
        $totalDays = $end->diffInDays($start);

        $reservations = $campaign->appointments()->where('date', $start->format('Y-m-d'))->count();

        while ($reservations >= $campaign->capacity_per_day && $day < $totalDays) {
            $day++;
            $start->addDays($day);
            $reservations = $campaign->appointments()->where('date', $start->format('Y-m-d'))->count();
        }

        if ($reservations >= $campaign->capacity_per_day || $day > $totalDays) {
            return back()->withErrors([
                'campaign' => 'No slots available in that campaign'
            ]);
        }

        $request->user()->reservations()->attach($campaign->id, ['date' =>  $start->format('Y-m-d')]);

        $request->user()->notify(new ReservationNotification());

        return view('citizen.reservecomplete')->with('diagnosed', $request->user()->is_diagnosed);
    }

    private function canReserve(Request $request) {
        return !$request->user()->answers()->where('question_user.created_at', '>', now()->subDays(14))->where('answer', 'Yes')->first();
    }
}
