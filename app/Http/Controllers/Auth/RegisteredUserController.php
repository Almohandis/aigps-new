<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\NationalId;
use App\Notifications\RegisterationNotification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        $cities = ['Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez', '6th of October'];
        // countries
        return view('auth.register')->with([
            'countries' => \Countries::getList('en'),
            'cities'    =>  $cities
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'national_id'       => ['required', 'max:14', 'min:14'], //# 'unique:users'
            'address'           => 'required|string',
            'birthdate'         => 'required',
            'gender'            => 'required',
            'country'           =>  'required|string',
            'city'              =>  'required|string'
        ]);

        //# check if the provided national id exists in the database
        $nationalId = NationalId::find($request->national_id);

        if (!$nationalId) {
            return redirect()->back()->withErrors(['national_id' => 'National ID is not valid']);
        }

        //# check if the user already has a record in the users table, may be his/her data was entered by a hospital staff before
        $user = User::where('national_id', $request->national_id)->first();
        $gender = ($request->gender === 'Male') ? 'Male' : 'Female';

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'national_id' => $request->national_id,
            'address'           =>  $request->address,
            'birthdate'         =>  $request->birthdate,
            'gender'            =>  $gender,
            'country'           =>  $request->country,
            'city'              =>  $request->city
        ];

        //# check if user exists
        if ($user) {
            $user->update($data);
        } else {
            //# if the user does not exist, create a new record
            $user = User::create($data);

            //# create a new record in medical passport for the user
            $user->passport()->create();
        }

        if ($request->workemail) {
            $user->emailProfiles()->create([
                'email' => $request->workemail
            ]);
        }

        //# user can have multiple phones, up to 10
        $phone = 1;
        while ($phone < 10) {
            $phone_number = $request->input('phone' . $phone);
            if ($phone_number) {
                $user->phones()->create([
                    'phone_number' => $phone_number
                ]);
            } else {
                break;
            }

            $phone++;
        }

        event(new Registered($user));

        $user->notify(new RegisterationNotification());

        // Auth::login($user);

        return view('auth.register-complete');
    }
}
