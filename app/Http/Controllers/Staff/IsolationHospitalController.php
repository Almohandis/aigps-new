<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HospitalStatistics;
use Illuminate\Support\Facades\Auth;
use App\Models\Hospital;

class IsolationHospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::where('is_isolation', 1)->get();
        return view('isolationHospital.isolation-hospital', compact('hospitals'));
    }

    public function modify(Request $request)
    {
        //# Check if the user is authorized to modify the hospital
        if (!$request->hospital)
            return redirect()->back()->with('message', 'Please choose a hospital');
        if (Auth::user()->hospitals()->where('hospital_id', $request->hospital)->first()) {
            $hospital = Hospital::find($request->hospital);
            if (
                $request->total_capacity === null
                || $request->available_beds === null
                || $request->recoveries === null
                || $request->deaths === null
            ) {
                return redirect()->back()->with('message', 'Please fill in the fields');
            }
            if (
                $request->total_capacity >= 0 && $request->available_beds >= 0
                && $request->recoveries >= 0 && $request->deaths >= 0
            ) {
                $hospital->update([
                    'capacity' => $request->total_capacity,
                    'available_beds' => $request->available_beds,
                ]);
                HospitalStatistics::create([
                    'hospital_id' => $hospital->id,
                    'date' => now(),
                    'recoveries' => $request->recoveries,
                    'deaths' => $request->deaths,
                ]);
            }
            return redirect('/staff/isohospital/modify')->with('message', 'Hospital statistics updated successfully');
        } else {
            return redirect()->back()->with('message', 'You are not authorized to modify this hospital');
        }
    }

    public function infection(Request $request)
    {

    }
}
