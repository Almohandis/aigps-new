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
        $hospitals = Hospital::query();

        if ($request->has('sort') && $request->sort) {
            $hospitals = $hospitals->orderBy($request->sort, $request->order == 'asc' ? 'asc' : 'desc');
        }


        if ($request->has('is_isolation') && $request->is_isolation) {
            $hospitals = $hospitals->where('is_isolation', $request->is_isolation == 'is_isolation');
        }

        if ($request->has('city') && $request->city) {
            $hospitals = $hospitals->where('city', $request->city);
        }

        $cities = City::all();

        return view('moh.doctors.hospitals')
            ->with('hospitals', $hospitals->paginate(10)->withQueryString())
            ->with('cities', $cities);
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
}
