<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NationalId;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $members = User::where('role_id', '!=', 3)->where('role_id', '!=', 9)->get();

        return view('admin.manage-roles', compact('members'));
    }

    public function update(Request $request)
    {
        foreach (array_combine($request->id, $request->role_id) as $id => $role) {
            $user = User::find($id)->update(['role_id' => $role]);
        }
        return redirect()->back()->with('success', 'Roles updated successfully');
    }

    public function add(Request $request)
    {
        if (!NationalId::where('national_id', $request->national_id)->exists()) {
            return redirect()->back()->with('message', 'National ID does not exist');
        } else {
            $user = User::where('national_id', $request->national_id)->first();
            if ($user) {
                if ($user->role_id != 3) {
                    return redirect()->back()->with('message', 'User with given national ID already a staff member');
                } else {
                    $user->update(['role_id' => $request->role_id]);
                    return redirect()->back()->with('message', 'Staff member added successfully');
                }
            } else {
                return redirect()->back()->with('message', 'User with given national ID does not exist');
            }
        }
    }
}
