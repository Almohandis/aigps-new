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

class IsolationHospitalController extends Controller
{
    protected $cities = ['6th of October', 'Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];

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
            if (false
                // $request->total_capacity === null
                // || $request->care_beds === null
                // || $request->avail_care_beds === null
                // || $request->available_beds === null
                // || $request->recoveries === null
                // || $request->deaths === null
            ) {
                return redirect()->back()->with('message', 'Please fill in the fields');
            }
            if (false
                // $request->total_capacity >= 0 && $request->available_beds >= 0 && $request->care_beds >= 0 && $request->avail_care_beds >= 0
                // && $request->recoveries >= 0 && $request->deaths >= 0
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

            $patients = Hospital::find($hospital_id)->patients()->where('checkout_date', null)->get();
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
                'checkout_date' => 3,
                'countries' => \Countries::getList('en'),
            );
            return view('isolationHospital.infection-more', compact('data'));
        } else {
            return redirect()->back()->with('message', 'Patient not found');
        }
    }

    //# Patient checkout
    public function checkout(Request $request, $id)
    {
        // $user = User::where('national_id', $id)->first();
        DB::select("UPDATE hospitalizations SET checkout_date=CURDATE() WHERE hospital_id=" . $request->user()->hospital_id . " AND user_id = (SELECT users.id FROM users WHERE users.national_id=" . $id . ")");
        // if ($user) {
        //     $user->update([
        //         'checkout_date' => now(),
        //     ]);
        return redirect()->back()->with('message', 'Patient checked out successfully');
        // } else {
        //     return redirect()->back()->with('message', 'Patient not found');
        // }
    }

    //# Detailed patient data submit
    public function submit(Request $request, $id)
    {
        // return $request;
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
        if ($request->phones) {
            foreach ($request->phones as $phone) {
                if (!$patient->phones()->create([
                    'phone_number' => $phone,
                ]))
                    $success = false;
            }
        }
        // return $phonesDelete;
        $infection_count = $patient->infections()->count();
        $patient->infections()->delete();
        // if ($request->infections) {
        //     foreach ($request->infections as $infection) {
        //         if (!$patient->infections()->create([
        //             'infection_date'    => $infection,
        //         ]))
        //             $success = false;
        //     }
        // }
        //////////////////////////////////////
        if ($request->infections) {
            for ($i = 0; $i < count($request->infections); $i++) {
                if ($request->infections[$i] == null) {
                    return redirect()->back()->with('message', 'Infection date is not valid');
                }
            }

            for ($i = 0; $i < count($request->infections); $i++) {
                $passed_away = $request->has_passed_away[$i];
                $patient->infections()->create([
                    'hospital_id' => $request->user()->hospital_id,
                    'infection_date'    => $request->infections[$i],
                    'is_recovered'  =>  $request->is_recovered[$i],
                    'has_passed_away'   => $request->has_passed_away[$i]
                ]);
                if ($passed_away == 1) {
                    DB::select("UPDATE hospitalizations SET checkout_date=CURDATE() WHERE hospital_id=" . $request->user()->hospital_id . " AND user_id = (SELECT users.id FROM users WHERE users.national_id=" . $id . ")");
                }
            }
            if ($infection_count != count($request->infections)) {
                InfectionNotificationJob::dispatch($request->user());
            }
        }
        /////////////////////////////////
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
            'cities' => $this->cities,
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

        //# check if the patient already in another hospital
        if (Hospital::where('id', '!=', $request->user()->hospital_id)->whereHas('patients', function ($query) use ($request) {
            $query->where('national_id', $request->national_id)->where('checkout_date', null);
        })->first()) {
            return redirect()->back()->with('message', 'This patient is already in another hospital');
        }

        //# check if the hospital has a free bed to hospitalize the patient
        $capacity = Hospital::find($request->user()->hospital_id)->capacity;
        $hospitalized_patients = Hospital::find($request->user()->hospital_id)->patients()->where('checkout_date', null)->count();
        if ($hospitalized_patients >= $capacity) {
            return redirect()->back()->with('message', 'There is no free bed in the hospital');
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

        $passed_away = 0;
        if ($request->infections) {
            for ($i = 0; $i < count($request->infections); $i++) {
                if ($request->infections[$i] == null) {
                    return redirect()->back()->with('message', 'Infection date is not valid');
                }
            }

            for ($i = 0; $i < count($request->infections); $i++) {
                $passed_away = $request->has_passed_away[$i];
                $user->infections()->create([
                    'hospital_id' => $request->user()->hospital_id,
                    'infection_date'    => $request->infections[$i],
                    'is_recovered'  =>  $request->is_recovered[$i],
                    'has_passed_away'   => $request->has_passed_away[$i]
                ]);
            }

            InfectionNotificationJob::dispatch($request->user());
        }

        if ($passed_away == 1) {
            DB::select("UPDATE hospitalizations SET checkout_date=CURDATE() WHERE hospital_id=" . $request->user()->hospital_id . " AND user_id = (SELECT users.id FROM users WHERE users.national_id=" . $request->national_id . ")");
        } else {
            $hospital->patients()
                ->attach($user->id, [
                    'checkin_date' => now(),
                    'checkout_date' => null,
                ]);
        }

        return redirect('/staff/isohospital/infection')->with('message', 'Patient information added successfully');
    }
}
