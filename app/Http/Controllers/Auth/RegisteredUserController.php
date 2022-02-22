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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        //# check if the provided national id exists in the database
        $nationalId = NationalId::find($request->national_id);

        if (!$nationalId) {
            return redirect()->back()->withErrors(['national_id' => 'National ID is not valid']);
        }

        //# check if the user already has a record in the users table, may be his/her data was entered by a hospital staff before
        $user = User::where('national_id', $request->national_id)->first();
        $email = $user->email;
        $password = $user->password;

        // return array($email, $password);

        //# check if user exists
        if ($user) {

            //# check if user is registered
            if ($email && $password) {
                $request->validate([
                    'name'          => ['required', 'string', 'max:255'],
                    'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password'      => ['required', 'confirmed', Rules\Password::defaults()],
                    'national_id'   => ['required', 'max:255', 'unique:users']
                ]);

                //# check if user is not registered
            } else if ((!$email) && (!$password)) {
                $request->validate([
                    'name'          => ['required', 'string', 'max:255'],
                    'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password'      => ['required', 'confirmed', Rules\Password::defaults()],
                    'national_id'   => ['required', 'max:255',] //# 'unique:users'
                ]);
            }
        }

        //# if the user already exists, update his/her data
        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {

            //# if the user does not exist, create a new record
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'national_id' => $request->national_id
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect('/survey');
    }
}
