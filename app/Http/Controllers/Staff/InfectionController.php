<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\InfectionNotificationJob;
use App\Models\HospitalStatistics;
use Illuminate\Support\Facades\Auth;
use App\Models\Hospital;
use App\Models\User;
use App\Models\NationalId;
use Illuminate\Support\Facades\DB;
use App\Models\City;

class InfectionController extends Controller {
    public function index(Request $request) {
        $hospital = $request->user()->hospital()->first();

        if (! $hospital || $hospital->is_isolation == false) {
            return view('isolationHospital.infection')
                ->with('hospital', null)
                ->withErrors('You arent a member of any isolation hospital !');
        }

        $patients = Hospital::find($hospital->id)->patients()->where('checkout_date', null)->paginate(10);

        return view('isolationHospital.infection')
            ->with('hospital', $hospital)
            ->with('patients', $patients);
    }

    public function checkout(Request $request, $hospitalization){
        DB::select("UPDATE hospitalizations SET checkout_date=CURDATE() WHERE id = {$hospitalization}");

        return redirect()->back()->withSuccess('Patient checked out successfully');
    }

    public function updateView(Request $request, User $user) {
        $cities = City::all();

        return view('isolationHospital.update-user')->with([
            'countries' => \Countries::getList('en'),
            'cities'    =>  $cities,
            'user'      =>  $user
        ]);
    }

    public function update(Request $request, User $user) {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255'],
            'national_id'       => ['required', 'max:14', 'min:14'],
            'address'           => 'required|string',
            'birthdate'         => 'required',
            'gender'            => 'required',
            'country'           =>  'required|string',
            'city'              =>  'required|string',
            'blood_type'        =>  'required|string'
        ]);

        if (! NationalId::find($request->national_id)) {
            return back()->withErrors('National Id Doesnt exist !');
        }

        $user->update($data);

        return back()->withSuccess('Patient data updated successfully !');
    }

    public function add(Request $request) {
        $request->validate([
            'national_id'       => ['required', 'max:14', 'min:14']
        ]);

        $user = User::where('national_id', $request->national_id)->first();

        if (! $user) {
            return back()->withErrors('A User with this national id doesnt exist !');
        }

        $hospital = Hospital::find($request->user()->hospital_id);

        if (! $hospital) {
            return back()->withErrors('You are not a member of any isolation hospital !');
        }

        if ($hospital->patients()->where('user_id', $user->id)->where('checkout_date', NULL)->first()) {
            return back()->withErrors('This user is already hospitalized !');
        }

        if ($hospital->capacity <= $hospital->patients()->count()) {
            return back()->withErrors('The hospital has reached its maximum capacity !');
        }

        $hospital->patients()->attach($user->id, [
            'checkin_date' => now(),
            'checkout_date' => null,
        ]);

        return back()->withSuccess('Patient added to the hospital successfully !');
    }
}
