<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class CampaignClerkController extends Controller
{
    public function index() {
        return view('clerk.clerk');
    }

    public function store(Request $request) {
        $request->validate([
            'national_id' => 'required|string|max:255',
            'blood_type' => 'required|string|max:3'
        ]);

        $user = User::where('national_id', $request->national_id)->first();

        if (! $user) {
            return redirect()->back()->withErrors(['national_id' => 'User not found']);
        }

        $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        if (! in_array($request->blood_type, $blood_types)) {
            return redirect()->back()->withErrors(['blood_type' => 'Invalid blood type']);
        }

        $user->update([
            'blood_type'    => $request->blood_type,
            'is_diagnosed'  => $request->is_diagnosed == 'true' ? true : false
        ]);

        $disease = 1;
        while (1) {
            $disease_name = $request->input('disease' . $disease);
            if (! $disease_name) {
                break;
            }

            $user->diseases()->create([
                'name' => $disease_name
            ]);

            $disease++;
        }

        if ($request->input('is_infected') == 'true' && ! $user->infection()->exists()) {
            $user->infection()->create([
                'infection_date'  => now()
            ]);
        }

        if ($request->input('is_recovered') == 'true' && $user->infection()->exists()) {
            $user->infection()->update([
                'is_recovered'      =>  true,
            ]);
        }

        return view('clerk.clerk')->with('success', 'User updated successfully');
    }
}