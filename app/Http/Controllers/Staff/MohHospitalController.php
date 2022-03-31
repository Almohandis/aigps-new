<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Campaign;
use App\Models\Hospital;
use App\Models\User;
use Symfony\Contracts\Service\Attribute\Required;
use App\Models\City;

class MohHospitalController extends Controller {
    public function index(Request $request) {
        $hospitals = Hospital::paginate(10);

        $cities = City::all();

        return view('moh.manage-hospitals', compact('hospitals', 'cities'));
    }

    public function create(Request $request) {
        Hospital::create([
            'name' => $request->name,
            'city' => $request->city,
            'capacity' => $request->capacity,
            'is_isolation' => $request->is_isolation ? 1 : 0,
        ]);

        return redirect('/staff/moh/manage-hospitals')->with('message', 'Hospital added successfully');
    }

    public function update(Request $request, Hospital $hospital) {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'capacity' => 'required',
        ]);

        $hospital->update([
            'name' => $request->name,
            'city' => $request->city,
            'capacity' => $request->capacity,
            'is_isolation' => $request->is_isolation ? 1 : 0,
        ]);

        return redirect('/staff/moh/manage-hospitals')->with('message', 'Hospital updated successfully');
    }

    public function delete(Request $request, Hospital $hospital) {
        $hospital->delete();

        return back()->with('message', 'Hospital deleted successfully');
    }

    public function updateView(Request $request, Hospital $hospital) {
        $cities = City::all();

        return view('moh.update-hospital')
            ->with('hospital', $hospital)
            ->with('cities', $cities);
    }
}
