<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Jobs\InfectionNotificationJob;
use App\Models\MedicalPassport;

class CampaignClerkController extends Controller
{
    public function index()
    {
        return view('clerk.clerk');
    }

    public function store(Request $request)
    {
        $request->validate([
            'national_id' => 'required|string|max:255',
            'blood_type' => 'required|string|max:3',
            'city'      =>      'required|string'
        ]);

        $user = User::where('national_id', $request->national_id)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['national_id' => 'User not found']);
        }

        $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        if (!in_array($request->blood_type, $blood_types)) {
            return redirect()->back()->withErrors(['blood_type' => 'Invalid blood type']);
        }

        if ($user->is_diagnosed && $request->is_diagnosed == 'true') {
            $medical_passport = $user->passport;
        }

        $user->update([
            'blood_type'    => $request->blood_type,
            'is_diagnosed'  => $request->is_diagnosed == 'true' ? true : false,
            'city'          => $request->city
        ]);

        $disease = 1;
        while (1) {
            $disease_name = $request->input('disease' . $disease);

            if (!$disease_name) {
                break;
            }

            $user->diseases()->create([
                'name' => $disease_name
            ]);

            $disease++;
        }

        if ($request->input('infection')) {
            $user->infections()->create([
                'infection_date'  => $request->infection
            ]);

            InfectionNotificationJob::dispatch($user);
        }

        if ($request->input('is_recovered') == 'true') {
            $user->infections()->update([
                'is_recovered'      =>  true,
            ]);
        }

        return view('clerk.clerk')->with('success', 'User updated successfully');
    }
}
