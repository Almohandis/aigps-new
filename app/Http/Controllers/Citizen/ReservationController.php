<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\ReservationNotification;
use App\Models\City;
use Twilio;

class ReservationController extends Controller
{
    public function index(Request $request) {
        if (!$this->canReserve($request)) {
            return view('citizen.survey-error');
        }

        $campaigns = Campaign::orderBy('start_date', 'asc')->get();

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
			'message' 			=> '',
		]);
    }

    public function reserve(Request $request, Campaign $campaign) {
        if (!$this->canReserve($request)) {
            return view('citizen.survey-error');
        }

        if ($campaign->end_date < now()) {
            return back()->withErrors([
                'campaign' => 'Campaign has ended'
            ])->withHelp([
                'title' => 'Campaign Reservation Help',
                'message' => 'You need to select another campaign that is currently active',
                'steps' =>  [
                    'Select another campaign.'
                ]
            ]);
        }

        if ($request->user()->reservations()->where('campaign_appointments.status', '!=', 'cancelled')->where('campaign_appointments.status', '!=', 'finished')->where('date', '>=', now())->count()) {
            return back()->withErrors([
                'campaign' => 'You have already reserved an appointment'
            ])->withHelp([
                'title' => 'Reservation Help',
                'message' => 'You can only reserve one appointment at a time. If you want to cancel your current reservation, please contact the campaign organizer.',
                'steps' =>  [
                    'You can cancel your reservation by clicking on the "Cancel Reservation" button.',
                    'You can view your reservation details by clicking on the "View Reservation" button.'
                ]
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
            ])->withHelp([
                'title' => 'Campaign Reservation Help',
                'message' => 'You need to select another campaign that is not full',
                'steps' =>  [
                    'Select another campaign.'
                ]
            ]);
        }

        // random date between now and end
        $appointmentDate = now()->addDays(rand(0, $end->diffInDays(now())));
        // add random time into the day
        $appointmentDate = $appointmentDate->addMinutes(rand(0, 1439))->format('Y-m-d H:i:s');

        $request->user()->reservations()->attach($campaign->id, ['date' =>  $appointmentDate]);

        $request->user()->notify(new ReservationNotification($campaign, $appointmentDate));

        return view('citizen.reservecomplete')->with('diagnosed', $request->user()->is_diagnosed);
    }

    private function canReserve(Request $request) {
        return !$request->user()->answers()->where('question_user.created_at', '>', now()->subDays(14))->where('answer', 'Yes')->first();
    }
}
