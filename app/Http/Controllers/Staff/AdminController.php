<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NationalId;
use App\Models\User;

class AdminController extends Controller {
    public function index() {
        $employees = User::employees()->paginate(10);

        $cities = ['6th of October', 'Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];

        $roles = User::getRoleNames();

        return view('admin.manage-roles')
            ->with('employees', $employees)
            ->with('cities', $cities)
            ->with('roles', $roles);
    }

    public function update(Request $request, User $employee) {
        $request->validate([
            'role' => ['required', 'numeric', 'between:1,9'],
        ]);

        $employee->update([
            'role_id' => $request->role,
        ]);

        return back()->withSuccess('User role has been updated successfully.');
    }

    public function add(Request $request) {
        $request->validate([
            'national_id'   =>  ['required', 'min:14', 'max:14', 'exists:national_ids'],
            'role_id'       =>  ['required', 'numeric', 'between:1,9'],
        ]);

        $user = User::where('national_id', $request->national_id)->first();

        if (!$user) {
            return back()->withErrors('A User with this national Id doesn\'t exist.');
        }

        if ($user->isEmployee()) {
            return back()->withErrors('This user is already an employee.');
        }

        $user->update([
            'role_id' => $request->role_id
        ]);

        return back()->withSuccess('Staff member added successfully');
    }
}
