<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\User;

class MohController extends Controller
{
    //# Get all hospitals to manage
    public function manageHospitals(Request $request)
    {
        $hospitals = Hospital::all();
        return view('moh.manage-hospitals', compact('hospitals'));
    }

    //# Update hospitals
    public function updateHospitals(Request $request)
    {
        // return 78;
        // return $request;
        $success = true;
        foreach (array_combine($request->id, $request->is_isolation) as $id => $is_isolation) {
            if (!Hospital::find($id)->update(['is_isolation' => $is_isolation])) {
                $success = false;
            }
        }
        if ($success)
            return redirect('/staff/moh/manage-hospitals')->with('message', 'Hospitals updated successfully');
        else
            return redirect('/staff/moh/manage-hospitals')->with('message', 'Hospitals could not be updated');
    }

    //# Get all hospitals to manage each hospital's doctors
    public function manageDoctors(Request $request)
    {
        $hospitals = Hospital::all();
        return view('moh.manage-doctors', compact('hospitals'));
    }

    //# Get all doctors working in a hospital
    public function getDoctors(Request $request, $id)
    {
        $doctors = Hospital::find($id)->clerks()->get();
        $doctors = json_encode($doctors);
        // print_r($doctors);
        echo $doctors;
    }

    //# Remove doctor from a hospital
    public function removeDoctor(Request $request, $id)
    {
        $doctor = User::find($id)->update([
            'hospital_id' => null,
        ]);
        echo $doctor;
    }

    //# Add new doctor to a hospital
    public function addDoctor(Request $request)
    {
        if (!$request->hospital_id)
            return redirect('/staff/moh/manage-doctors')->with('message', 'Please select a hospital');
        $hospital = Hospital::find($request->hospital_id);
        if ($hospital)
            $added = User::where('national_id', $request->national_id)->update([
                'hospital_id' => $hospital->id,
            ]);
        else
            $added = false;
        if ($added)
            return redirect('/staff/moh/manage-doctors')->with('message', 'Doctor added successfully');
        else
            return redirect('/staff/moh/manage-doctors')->with('message', 'Doctor could not be added');
    }

    public function manageCampaigns(Request $request)
    {
    }
}
