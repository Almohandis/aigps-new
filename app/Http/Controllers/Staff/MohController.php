<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospital;

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

    public function manageDoctors(Request $request)
    {
    }
    public function manageCampaigns(Request $request)
    {
    }
}
