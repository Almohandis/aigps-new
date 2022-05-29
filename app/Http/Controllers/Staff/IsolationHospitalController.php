<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\InfectionNotificationJob;
use App\Models\HospitalStatistics;
use Illuminate\Support\Facades\Auth;
use App\Models\Hospital;
use App\Models\User;
use App\Models\NationalId;
use Illuminate\Support\Facades\DB;

class IsolationHospitalController extends Controller
{
    public function index(Request $request)
    {
        $hospital = $request->user()->hospital()->first();

        if (!$hospital || !$hospital->is_isolation) {
            return view('isolationHospital.isolation-hospital')
                ->with('hospital', null)
                ->withErrors('You arent a member of any isolation hospital !');
        }

        return view('isolationHospital.isolation-hospital')
            ->with('hospital', $hospital);
    }

    public function update(Request $request)
    {
        $request->validate([
            'capacity'          =>  ['required', 'numeric', 'min:0'],
            'recoveries'        =>  ['required', 'numeric', 'min:0'],
            'deaths'            =>  ['required', 'numeric', 'min:0']
        ]);

        $hospital = $request->user()->hospital()->first();

        if (!$hospital || $hospital->is_isolation == false) {
            return back()
                ->with('hospital', null)
                ->withErrors('You arent a member of any isolation hospital !');
        }

        $hospital->update([
            'capacity'          =>      $request->capacity
        ]);

        HospitalStatistics::create([
            'hospital_id'       => $hospital->id,
            'date'              => now(),
            'recoveries'        => $request->recoveries,
            'deaths'            => $request->deaths,
        ]);

        return back()->withSuccess('Hospital Statistics updated successfully.');
    }
}
