<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index(Request $request) {
        $cities = ['6th of October', 'Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];
        $countries = \Countries::getList('en');

        return view('citizen.profile')
            ->with('cities', $cities)
            ->with('countries', $countries)
            ->with('user', $request->user());
    }

    public function update(Request $request) {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255'],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'address'           => 'required|string',
            'telephone_number'  => 'required',
            'birthdate'         => 'required',
            'gender'            => 'required',
            'country'           =>  'required|string',
            'city'              =>  'required|string'
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

        return back()->with('message', 'Settings updated successfully !');
    }
}
