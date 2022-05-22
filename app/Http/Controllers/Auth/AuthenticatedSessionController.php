<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('national_id', $request->national_id)->first();
        if (! $user) {
            return back()->withErrors(['national_id' => 'This account doesnt exist !'])
            ->withHelp([
                'title' => 'Login help',
                'message' => 'You need to create an account first',
                'steps' =>  [
                    'Click on the Register Button on the top nav-bar',
                    'Fill in the form with your information',
                    'Verify your account using the email',
                    'Try to log in again.'
                ]
            ]);
        }

        if (! $user->email_verified_at) {
            return back()->withErrors(['email' => 'This account is not verified, please follow the verification link sent to you via email.'])
            ->withHelp([
                'title' => 'Login help',
                'message' => 'You need to verify your account first',
                'steps' =>  [
                    'Open your email',
                    'Follow the link provided to you in order to verify your account',
                    'Try to log in again.'
                ]
            ]);
        }

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
