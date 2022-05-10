<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Campaign;
use App\Models\Hospital;
use App\Models\User;
use App\Models\NationalId;
use Symfony\Contracts\Service\Attribute\Required;
use App\Models\City;

class MohDoctorController extends Controller {
    public function index(Request $request) {
        $doctors = User::with('hospital')->where('hospital_id', '!=', NULL);
        $order = $request->input('order') == 'asc' ? 'asc' : 'desc';

        if ($request->has('sort') && $request->input('sort') == 'name') {
            $doctors->orderBy('name', $order);
        }

        if ($request->has('sort') && $request->input('sort') == 'national_id') {
            $doctors->orderBy('national_id', $order);
        }

        if ($request->has('search') && $request->input('search') != '') {
            $doctors->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $hospitals = Hospital::get(['id', 'name']);

        return view('moh.manage-doctors')
            ->with('doctors', $doctors->paginate(10)->withQueryString())
            ->with('hospitals', $hospitals);
    }

    public function users(Request $request) {
        $users = User::where('hospital_id', NULL);
        $order = $request->input('order') == 'asc' ? 'asc' : 'desc';

        if ($request->has('sort') && $request->input('sort') == 'name') {
            $users->orderBy('name', $order);
        }

        if ($request->has('sort') && $request->input('sort') == 'national_id') {
            $users->orderBy('national_id', $order);
        }

        if ($request->has('search') && $request->input('search') != '') {
            $users->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $hospitals = Hospital::get(['id', 'name']);

        return view('moh.manage-users')
            ->with('users', $users->paginate(10)->withQueryString())
            ->with('hospitals', $hospitals);
    }

    public function update(Request $request, User $doctor) {
        $request->validate([
            'hospital'      =>      'required|numeric'
        ]);



        $doctor->update([
            'hospital_id'   =>   $request->hospital == '-1' ? NULL : $request->hospital
        ]);

        return back()->withSuccess('Doctor hospital has been changed successfully');
    }

    public function doctors(Request $request, Hospital $hospital) {
        $doctors = $hospital->clerks()->paginate(10);

        return view('moh.doctors.doctors')
            ->with('doctors', $doctors)
            ->with('hospital', $hospital);
    }

    public function delete(Request $request, User $doctor) {
        $doctor->update([
            'hospital_id'   =>  null,
        ]);

        return back()->withSuccess('Doctor removed from hospital successfully');
    }

    public function add(Request $request, Hospital $hospital) {
        $request->validate([
            'national_id'   =>  'required|numeric|digits:14',
        ]);

        $national_id = NationalId::find($request->national_id);

        if (! $national_id) {
            return back()->withErrors('National ID not found');
        }

        $user = User::where('national_id', $national_id->national_id)->first();

        if (! $user) {
            return back()->withErrors('User not found');
        }

        if ($user->hospital_id) {
            return back()->withErrors('User is already a doctor of another hospital');
        }

        if ($user->hospital_id == $hospital->id) {
            return back()->withErrors('User is already a doctor of this hospital');
        }

        $user->update([
            'hospital_id'   =>  $hospital->id
        ]);

        return back()->withSuccess('Doctor added to hospital successfully');
    }

    public function details(Request $request, $user) {
        $user = User::find($user);
        $campaign = \DB::table('campaign_doctors')->where('user_id', $user->id)->first();

        if ($campaign) {
            $campaign = Campaign::find($campaign->campaign_id);
        } else {
            $campaign = NULL;
        }

        if (!$user) {
            return back()->withErrors('User not found');
        }

        return view('moh.doctors.details')
            ->with('user', $user)
            ->with('hospital', $user->hospital?->name)
            ->with('campaign', $campaign?->address);
    }
}
