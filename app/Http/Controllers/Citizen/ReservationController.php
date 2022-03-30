<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\ReservationNotification;

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

        $cities = [
            'Alexandria'  =>  [
              'lat' =>  31.2001,
              'lng' =>  29.9187,
            ],
            'Aswan'  =>  [
              'lat' =>  24.0889,
              'lng' =>  32.8998,
            ],
            'Asyut'  =>  [
              'lat' =>  27.1783,
              'lng' =>  31.1859,
            ],
            'Beheira'  =>  [
              'lat' =>  30.8481,
              'lng' =>  30.3436,
            ],
            'Beni Suef'  =>  [
              'lat' =>  29.0661,
              'lng' =>  31.0994,
            ],
            'Cairo'  =>  [
              'lat' =>  30.0444,
              'lng' =>  31.2357,
            ],
            'Dakahlia'  =>  [
              'lat' =>  31.1656,
              'lng' =>  31.4913,
            ],
            'Damietta'  =>  [
              'lat' =>  31.4175,
              'lng' =>  31.8144,
            ],
            'Faiyum'  =>  [
              'lat' =>  29.3565,
              'lng' =>  30.6200,
            ],
            'Gharbia'  =>  [
              'lat' =>  30.8754,
              'lng' =>  31.0335,
            ],
            'Giza'  =>  [
              'lat' =>  30.0131,
              'lng' =>  31.2089,
            ],
            'Helwan'  =>  [
              'lat' =>  29.8403,
              'lng' =>  31.2982,
            ],
            'Ismailia'  =>  [
              'lat' =>  30.5965,
              'lng' =>  32.2715,
            ],
            'Kafr El Sheikh'  =>  [
              'lat' =>  31.1107,
              'lng' =>  30.9388,
            ],
            'Luxor'  =>  [
              'lat' =>  25.6872,
              'lng' =>  32.6396,
            ],
            'Matruh'  =>  [
              'lat' =>  31.3543,
              'lng' =>  27.2373,
            ],
            'Minya'  =>  [
              'lat' =>  28.0871,
              'lng' =>  30.7618,
            ],
            'Monufia'  =>  [
              'lat' =>  30.5972,
              'lng' =>  30.9876,
            ],
            'New Valley'  =>  [
              'lat' =>  24.5456,
              'lng' =>  27.1735,
            ],
            'North Sinai'  =>  [
              'lat' =>  30.2824,
              'lng' =>  33.6176,
            ],
            'Port Said'  =>  [
              'lat' =>  31.2653,
              'lng' =>  32.3019,
            ],
            'Qalyubia'  =>  [
              'lat' =>  30.3292,
              'lng' =>  31.2168,
            ],
            'Qena'  =>  [
              'lat' =>  26.1551,
              'lng' =>  32.7160,
            ],
            'Red Sea'  =>  [
              'lat' =>  24.6826,
              'lng' =>  34.1532,
            ],
            'Sharqia'  =>  [
              'lat' =>  30.7327,
              'lng' =>  31.7195,
            ],
            'Sohag'  =>  [
              'lat' =>  26.5591,
              'lng' =>  31.6957,
            ],
            'South Sinai'  =>  [
              'lat' =>  29.3102,
              'lng' =>  34.1532,
            ],
            'Suez'  =>  [
              'lat' =>  29.9668,
              'lng' =>  32.5498,
            ],
            '6th of October'  =>  [
              'lat' =>  29.9285,
              'lng' =>  30.9188,
            ]
        ];

        $citiesData = User::whereHas('infections', function ($query) {
            $query->where('is_recovered', false);
        })
        ->selectRaw('city, count(*) as total')
        ->groupBy('city')
        ->get();

        $max = 0;

        foreach($citiesData as $cityData) {
            $max = max($max, $cityData->total);

            foreach($cities as $city => $data) {
                if ($city == $cityData->city) {
                    $cityData->lat = $data['lat'];
                    $cityData->lng = $data['lng'];
                    break;
                }
            }

        }

        return view('citizen.reservation')->with([
            'campaigns' => $campaigns,
            'cities' => $citiesData,
            'max' => $max,
            'message' => $request->user()->is_diagnosed ? null : 'You will recieve diagnosis during your first reservation.',
        ]);
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

        $request->user()->notify(new ReservationNotification());

        return view('citizen.reservecomplete');
    }

    private function canReserve(Request $request) {
        return ! $request->user()->answers()->where('question_user.created_at', '>', now()->subDays(14))->where('answer', 'Yes')->first();
    }
}
