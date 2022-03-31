<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalPassport;

class MedicalPassportController extends Controller {
    public function index(Request $request) {
        $request->validate([
            'passport_number'       =>      ['required', 'min:8']
        ]);

        $passport = $request->user()->passport()->first();

        if (! $passport) {
            return back()->withErrors('You have no medical passport !');
        }

        if ($passport->vaccine_dose_count < 2) {
            return back()->withErrors('You havent taken all the doses of the vaccine !');
        }

        if ($request->user()->infections()->where('is_recovered', false)->count() > 0) {
            return back()->withErrors('You are currently infected, you cannot generate a medical passport until you recover !');
        }

        $passport->passport_number = $request->passport_number;
        $passport->save();

        $dates = $passport->dates()->get();

        $infections = $request->user()->infections()->get();

        $chronic_diseases = $request->user()->chronicDiseases()->get();

        return view('medical-passport')
            ->with('passport', $passport)
            ->with('date', now())
            ->with('dates', $dates)
            ->with('infections', $infections)
            ->with('chronic_diseases', $chronic_diseases);
    }
}
