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

        $passport->passport_number = $request->passport_number;
        $passport->save();

        $dates = $passport->dates()->get();

        return view('medical-passport')
            ->with('passport', $passport)
            ->with('date', now())
            ->with('dates', $dates);
    }
}
