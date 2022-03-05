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
                || $request->care_beds === null
                || $request->avail_care_beds === null
                || $request->available_beds === null
                || $request->recoveries === null
                || $request->deaths === null
            ) {
                return redirect()->back()->with('message', 'Please fill in the fields');
            }
            if (
                $request->total_capacity >= 0 && $request->available_beds >= 0 && $request->care_beds >= 0 && $request->avail_care_beds >= 0
                && $request->recoveries >= 0 && $request->deaths >= 0
            ) {
                $hospital->update([
                    'capacity' => $request->total_capacity,
                    'care_beds' => $request->care_beds,
                    'avail_care_beds' => $request->avail_care_beds,
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
        if (!Auth::user()->hospital_id) {
            return redirect()->back();
        }

        $hospital = Hospital::find(Auth::user()->hospital_id);
        if ($hospital) {
            $hospital_id = $hospital->id;

            $patients = Hospital::find($hospital_id)->patients()->get(); //->where('checkout_date', null)->get();
            // return $patients;
            if (!$patients) {
                return view('isolationHospital.infection');
            } else {
                return view('isolationHospital.infection', compact('patients'));
            }
        } else {
            return redirect()->back();
        }
    }

    //# Initial patient data save
    public function save(Request $request, $id)
    {
        // return $request->all();
        $patient = Hospital::find(Auth::user()->hospital_id)->first()->patients()->where('national_id', $id);
        if ($request->name == null) {
            return redirect()->back()->with('message', 'Please fill in the fields');
        }
        if ($patient) {
            $patient = User::where('national_id', $id)->update([
                'name' => $request->name,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'telephone_number' => $request->telephone_number,
                'gender' => $request->gender,
                'blood_type' => $request->blood_type,
                'is_diagnosed' => $request->is_diagnosed,
            ]);
        } else
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
        if ($user) {
            $phones = $user->phones;
            $infections = $user->infections()->get();
            $data = array(
                'user' => $user,
                'phones' => $phones,
                'infections' => $infections,
                'countries' => \Countries::getList('en'),
            );
            return view('isolationHospital.infection-more', compact('data'));
        } else {
            return redirect()->back()->with('message', 'Patient not found');
        }
    }

    //# Detailed patient data submit
    public function submit(Request $request, $id)
    {
        $hospital_id = Auth::user()->hospital_id;
        if (!$hospital_id)
            return redirect('/staff/isohospital/infection')->with('message', 'You are not authorized to modify this patient');

        $patients = Hospital::find($hospital_id)->patients()->get();
        // dd($patients->toArray());

        if (!$patients) {
            return redirect('/staff/isohospital/infection')->with('message', 'There is no patient in this hospital');
        }

        $patient = Hospital::find($hospital_id)->patients()->where('national_id', $id)->where('checkout_date', null)->first();
        // return $patient;
        // dd($patient->toArray());
        if (!$patient) {
            return redirect('/staff/isohospital/infection')->with('message', 'This is not a valid patient data');
        }


        $success = true;
        // return $request->getContent();
        $patient->update([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'address' => $request->address,
            'telephone_number' => $request->telephone_number,
            'gender' => $request->gender,
            'country'   =>  $request->country,
            'blood_type'    =>  $request->blood_type,
            'is_diagnosed'  =>  $request->is_diagnosed,
        ]);
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
        // return $request;
        $hospital = Hospital::find($request->user()->hospital_id);
        if (!$hospital) {
            return redirect()->back()->with('message', 'You are not authorized to add new patients');
        }

        if (!NationalId::find($request->national_id)) {
            return 4;

            return redirect()->back()->with('message', 'National ID is not valid');
        }

        //# if patient doesn't have a record in users table, create a record in both users and medical passport tables
        $user = User::where('national_id', $request->national_id)->first();
        $create_passport = false;
        if (!$user) {
            $create_passport = true;
        }

        //# check if the patinet already in the hospital
        if (Hospital::find($request->user()->hospital_id)->patients()->where('national_id', $request->national_id)->where('checkout_date', null)->first()) {
            return redirect()->back()->with('message', 'This patient is already in the hospital');
        }

        //# check if patient has a record in users table, create new record or update existing one
        $user = User::updateOrCreate(
            ['national_id' => $request->national_id],
            [
                'national_id'   =>  $request->national_id,
                'name' => $request->name,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'telephone_number' => $request->telephone_number,
                'gender' => $request->gender,
                'country'   => $request->country,
                'blood_type'    =>  $request->blood_type,
                'is_diagnosed'  =>  $request->is_diagnosed,
                'city'          =>  $request->city
            ]
        );
        // return $user;

        //# create new passport if user doesn't have a record in medical passport table (new patient)
        if ($create_passport) {
            $user->passport()->create();
        }

        $user->phones()->delete();

        if ($request->phones) {
            foreach ($request->phones as $phone) {
                $user->phones()->create([
                    'phone_number' => $phone,
                ]);
            }
        }

        if ($request->infections) {
            foreach ($request->infections as $infection) {
                $user->infections()->create([
                    'infection_date'    => $infection,
                ]);
            }
        }

        $hospital->patients()
            ->attach($user->id, [
                'checkin_date' => now(),
                'checkout_date' => null,
            ]);

        return redirect('/staff/isohospital/infection')->with('message', 'Patient information added successfully');
    }
}
