<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicalPassportController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->passport_number) {
            return redirect()->back()->with('message', 'Please enter you passport number'); //'Не введен номер паспорта');
        }
        if (!$request->user()->passport()->first()) {
            return redirect()->back()->with('message', 'You have no passport yet');
        }
        $request->user()->passport()->first()->update([
            'passport_number' => $request->passport_number,
        ]);
        $medical_passport = $request->user()->passport()->first();
        $vaccine_dates = $request->user()->passport()->dates()->get();
        return view('medical-passport', compact('medical_passport', 'vaccine_dates'));
    }
}
