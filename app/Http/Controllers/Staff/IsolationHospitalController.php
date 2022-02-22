<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Middleware\NationalId;
use App\Models\HospitalStatistics;
use Illuminate\Support\Facades\Auth;
use App\Models\Hospital;
use App\Models\User;
use App\Models\NationalId;

class IsolationHospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::where('is_isolation', 1)->get();
        return view('isolationHospital.isolation-hospital', compact('hospitals'));
    }

    public function modify(Request $request)
    {
        //# Check if the user is authorized to modify the hospital
        if (!$request->hospital)
            return redirect()->back()->with('message', 'Please choose a hospital');
        //('hospital_id',$request->hospital)
        if (Auth::user()->hospital_id == $request->hospital) {
            $hospital = Hospital::find($request->hospital);
            if (
                $request->total_capacity === null
                || $request->available_beds === null
                || $request->recoveries === null
                || $request->deaths === null
            ) {
                return redirect()->back()->with('message', 'Please fill in the fields');
            }
            if (
                $request->total_capacity >= 0 && $request->available_beds >= 0
                && $request->recoveries >= 0 && $request->deaths >= 0
            ) {
                $hospital->update([
                    'capacity' => $request->total_capacity,
                    'available_beds' => $request->available_beds,
                ]);
                HospitalStatistics::create([
                    'hospital_id' => $hospital->id,
                    'date' => now(),
                    'recoveries' => $request->recoveries,
                    'deaths' => $request->deaths,
                ]);
            }
            return redirect('/staff/isohospital/modify')->with('message', 'Hospital statistics updated successfully');
        } else {
            return redirect()->back()->with('message', 'You are not authorized to modify this hospital');
        }
    }

    public function infection(Request $request)
    {
        $hospital_id = Hospital::find(Auth::user()->hospital_id)->id;
        $patients = Hospital::find($hospital_id)->patients()->where('checkout_date', null)->get();
        return view('isolationHospital.infection', compact('patients'));
    }

    public function edit(Request $request)
    {
        $phones = User::where('national_id', $request->query('id'))->first()->phones()->get();
        echo json_encode($phones);
    }

    //# Initial patient data save
    public function save(Request $request, $id)
    {
        $patient = Hospital::find(Auth::user()->hospital_id)->first()->patients()->where('national_id', $id);
        if ($patient)
            $patient = User::where('national_id', $id)->update([
                'name' => $request->name,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'telephone_number' => $request->telephone_number,
                'gender' => $request->gender,
                'blood_type' => $request->blood_type,
                'is_diagnosed' => $request->is_diagnosed,
            ]);
        else
            return redirect('/staff/isohospital/infection')->with('message', 'You are not authorized to modify this patient');
        if ($patient)
            return redirect('/staff/isohospital/infection')->with('message', 'Patient information updated successfully');
        else
            return redirect('/staff/isohospital/infection')->with('message', 'Patient information could not be updated');
    }

    //# Detailed patient data display
    public function more(Request $request, $id)
    {
        $user = User::where('national_id', $id)->first();
        $phones = $user->phones;
        $infections = $user->infections()->get();
        $data = array(
            'user' => $user,
            'phones' => $phones,
            'infections' => $infections,
            'countries' => \Countries::getList('en'),
        );
        return view('isolationHospital.infection-more', compact('data'));
    }

    //# Detailed patient data submit
    public function submit(Request $request, $id)
    {
        $hospital_id = Auth::user()->hospital_id;
        if (!$hospital_id)
            return redirect('/staff/isohospital/infection')->with('message', 'You are not authorized to modify this patient');

        $patients = Hospital::find($hospital_id)->first()->patients();

        if (!$patients)
            return redirect('/staff/isohospital/infection')->with('message', 'There is no patient in this hospital');

        $patient = $patients->where('national_id', $id)->where('checkout_date', null)->first();

        if (!$patient)
            return redirect('/staff/isohospital/infection')->with('message', 'This is not a valid patient data');


        $success = true;
        $userUpdate = $patient->update([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'address' => $request->address,
            'telephone_number' => $request->telephone_number,
            'gender' => $request->gender,
            'country'   =>  $request->country,
            'blood_type'    =>  $request->blood_type,
            'is_diagnosed'  =>  $request->is_diagnosed,
        ]);
        if (!$userUpdate)
            $success = false;

        // return $userUpdate;
        $patient->phones()->delete();
        if ($request->phones)
            foreach ($request->phones as $phone) {
                if (!$patient->phones()->create([
                    'phone_number' => $phone,
                ]))
                    $success = false;
            }
        // return $phonesDelete;
        $patient->infections()->delete();
        if ($request->infections)
            foreach ($request->infections as $infection) {
                if (!$patient->infections()->create([
                    'infection_date'    => $infection,
                ]))
                    $success = false;
            }
        // return $infectionsDelete;
        if ($success)
            return redirect('/staff/isohospital/infection')->with('message', 'Patient information updated successfully');
        else
            return redirect('/staff/isohospital/infection')->with('message', 'Patient information could not be updated');
    }

    public function addPatient(Request $request)
    {
        $data = array(
            'countries' => \Countries::getList('en'),
        );
        return view('isolationHospital.add-patient', compact('data'));
    }

    public function submitAddPatient(Request $request)
    {
        // return $request->all();
        if (!NationalId::find($request->national_id))
            return redirect()->back()->with('message', 'National ID is not valid');

        //# check if patient has a record in users table
        $user = User::where('national_id', $request->national_id)->first();

        $success = true;
        if ($user) {

            //# update user data
            $success =  $user->update([
                'name' => $request->name,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'telephone_number' => $request->telephone_number,
                'gender' => $request->gender,
                'country'   => $request->country,
                'blood_type'    =>  $request->blood_type,
                'is_diagnosed'  =>  $request->is_diagnosed,
            ]);

            //# update phones
            $user->phones()->delete();
            if ($request->phones)
                foreach ($request->phones as $phone) {
                    if (!$user->phones()->create([
                        'phone_number' => $phone,
                    ]))
                        $success = false;
                }

            // return $phonesDelete;
            //# update infections
            $user->infections()->delete();
            if ($request->infections)
                foreach ($request->infections as $infection) {
                    if (!$user->infections()->create([
                        'infection_date'    => $infection,
                    ]))
                        $success = false;
                }

            if ($success) {
                return redirect('/staff/isohospital/infection')->with('message', 'Patient information updated successfully');
            } else {
                return redirect('/staff/isohospital/infection')->with('message', 'Patient information could not be updated');
            }
        } else {
            //# create user data
            $user = User::create([
                'national_id' => $request->national_id,
                'email'  => 0,
                'password' => 0,
                'name' => $request->name,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'telephone_number' => $request->telephone_number,
                'gender' => $request->gender,
                'country'   => $request->country,
                'blood_type'    =>  $request->blood_type,
                'is_diagnosed'  =>  $request->is_diagnosed,
            ]);

            //# insert phones
            if ($request->phones)
                foreach ($request->phones as $phone) {
                    if (!$user->phones()->create([
                        'phone_number' => $phone,
                    ]))
                        $success = false;
                }

            //# insert infections
            if ($request->infections)
                foreach ($request->infections as $infection) {
                    if (!$user->infections()->create([
                        'infection_date'    => $infection,
                    ]))
                        $success = false;
                }

            if ($success) {
                return redirect('/staff/isohospital/infection')->with('message', 'Patient information added successfully');
            } else {
                return redirect('/staff/isohospital/infection')->with('message', 'Patient information could not be added');
            }
        }
    }
}
