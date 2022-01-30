<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NationalId;
use Illuminate\Support\Facades\Redirect;

class NationalIdController extends Controller
{
    //# Redirect to national id modify page
    public function index()
    {
        // $nationalIds = NationalId::all();
        return view('nationalid-modify');
    }

    //# Modify national id
    public function modify(Request $request)
    {
        if (!$request->entered_id)
            return redirect()->back()->with('message', 'Please enter a valid national ID');
        $check_id = NationalId::find($request->entered_id);

        if ($request->add) {
            if ($check_id) {
                return redirect()->back()->with('message', 'National ID already exists');
            } else {
                NationalId::create([
                    'national_id' => $request->entered_id
                ]);
                return redirect('/staff/nationalid/modify')->with('message', 'National ID added successfully');
            }
        } else if ($request->delete) {
            if ($check_id) {
                $check_id->delete();
                return redirect('/staff/nationalid/modify')->with('message', 'National ID deleted successfully');
            } else {
                return redirect()->back()->with('message', 'National ID does not exist');
            }
        }
    }
}
