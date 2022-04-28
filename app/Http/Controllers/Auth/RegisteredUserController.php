<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailVerificationToken;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\NationalId;
use App\Notifications\RegisterationNotification;
use App\Models\City;
use Twilio;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        $cities = City::all();
        
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
            'city'              =>  'required|string',
            'telephone_number'  =>  'required|string|unique:users'
        ]);

        // only allow people between the age of 15 to 60
        $age = \Carbon\Carbon::parse(\Carbon\Carbon::now())->diffInYears(\Carbon\Carbon::parse($request->birthdate));
        if ($age < 15 || $age > 60) {
            return redirect()->back()->withErrors(['birthdate' => 'You must be between the age of 15 to 60']);
        }

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
            'city'              =>  $request->city,
            'telephone_number'  =>  $request->telephone_number
        ];

        //# check if user exists
        if ($user && ! $user->password) {
            $user->update($data);
        } else if ($user && $user->password) {
            return back()->withErrors(['national_id' => 'A User with this national Id already exists']);
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

        // event(new Registered($user));

        $token = Str::random(40);

        while (EmailVerificationToken::where('token', $token)->exists()) {
            $token = Str::random(40);
        }

        EmailVerificationToken::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        $user->notify(new RegisterationNotification($token));
        Twilio::message($user->telephone_number, 'Your account in AIGPS has been created successfully');

        return view('auth.register-complete');
    }

    public function verify($token) {
        $emailVerificationToken = EmailVerificationToken::where('token', $token)->first();

        if (! $emailVerificationToken) {
            return redirect('/');
        }

        $user = $emailVerificationToken->user;

        if ($user->email_verified_at) {
            return redirect('/');
        }

        $user->email_verified_at = now();
        $user->save();

        $emailVerificationToken->delete();

        return redirect('/login');
    }
}
