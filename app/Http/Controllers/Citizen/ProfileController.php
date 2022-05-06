<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\City;

class ProfileController extends Controller
{
    public function index(Request $request) {
        $cities = City::all();
        $countries = \Countries::getList('en');

        $passport = $request->user()->passport()->first();
        $hasPassport = false;

        if ($passport && $passport->vaccine_dose_count >= 2 && $request->user()->infections()->where('is_recovered', false)->count() == 0) {
            $hasPassport = true;
        }

        return view('citizen.profile')
            ->with('cities', $cities)
            ->with('countries', $countries)
            ->with('user', $request->user())
            ->with('hasPassport', $hasPassport);
    }

    public function update(Request $request) {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255'],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'address'           => 'required|string',
            'birthdate'         => 'required',
            'gender'            => 'required',
            'country'           =>  'required|string',
            'city'              =>  'required|string',
            'telephone_number'  =>  'required'
        ]);

        $gender = ($request->gender === 'Male') ? 'Male' : 'Female';

        $request->user()->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'national_id'       => $request->national_id,
            'address'           =>  $request->address,
            'telephone_number'  =>  $request->telephone_number,
            'birthdate'         =>  $request->birthdate,
            'gender'            =>  $gender,
            'country'           =>  $request->country,
            'city'              =>  $request->city
        ]);

        return back()->withSuccess('Settings updated successfully !');
    }
}
