<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Carbon\Carbon;

class ReservationController extends Controller {
    public function index(Request $request) {
        if (! $this->canReserve($request)) {
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
            }
        }

        if ($request->user()->is_diagnosed) {
            return view('citizen.reservation1')->with([
                'campaigns' => $campaigns,
                'message' => null,
            ]);
        } else {
            return view('citizen.reservation1')
                ->with([
                    'campaigns' => $campaigns,
                    'message' => 'You have to get a diagnosis appointment first'
                ]);
        }
    }

    public function reserve(Request $request, Campaign $campaign) {
        if (! $this->canReserve($request)) {
            return view('citizen.survey-error');
        }

        if ($campaign->end_date < now()) {
            return back()->withErrors([
                'campaign' => 'Campaign has ended'
            ]);
        }

        if ($request->user()->reservations()->where('campaign_appointments.status', '!=', 'cancelled')->where('date', '>=', now())->count()) {
            return back()->withErrors([
                'campaign' => 'You have already reserved an appointment'
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

        return view('citizen.reservecomplete');
    }

    private function canReserve(Request $request) {
        return ! $request->user()->answers()->where('question_user.created_at', '>', now()->subDays(14))->where('answer', 'Yes')->first();
    }
}
