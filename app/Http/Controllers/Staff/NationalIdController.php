<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NationalId;
use Illuminate\Support\Facades\Redirect;

class NationalIdController extends Controller {
    public function index() {
        $nationalIds = NationalId::paginate(10);

        return view('national-id-entry.index')
            ->with('nationalIds', $nationalIds);
    }

    public function add(Request $request) {
        $request->validate([
            'national_id'   =>  ['required', 'min:14', 'max:14', 'unique:national_ids']
        ]);

        $nationalId = new NationalId();
        $nationalId->national_id = $request->national_id;
        $nationalId->save();

        return back()->withSuccess('National Id has been added successfully.');
    }

    public function delete(Request $request) {
        $request->validate([
            'national_id'   =>  ['required', 'exists:national_ids']
        ]);

        $nationalId = NationalId::find($request->national_id);
        $nationalId->delete();

        return back()->withSuccess('National Id has been deleted successfully.');
    }

    public function update(Request $request) {
        $request->validate([
            'national_id'   =>  ['required', 'min:14', 'max:14', 'exists:national_ids'],
            'national_id_new'   =>  ['required', 'min:14', 'max:14']
        ]);

        $nationalId = NationalId::find($request->national_id);

        $nationalId->national_id = $request->national_id_new;
        $nationalId->save();

        return back()->withSuccess('National Id has been updated successfully.');
    }
}
