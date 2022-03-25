<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Campaign;
use App\Models\Hospital;
use App\Models\User;
use Symfony\Contracts\Service\Attribute\Required;

class MohHospitalController extends Controller {
    public function index(Request $request) {
        $hospitals = Hospital::all();
        $cities = ['Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez', '6th of October'];

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
        $cities = ['Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez', '6th of October'];
        return view('moh.update-hospital')
            ->with('hospital', $hospital)
            ->with('cities', $cities);
    }
}
