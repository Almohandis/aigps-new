<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentsController extends Controller
{
    public function index(Request $request) {
        $appointments = $request->user()->reservations()->orderBy('date', 'asc')->get();

        return view('citizen.appointments')->with('appointments', $appointments);
    }

    public function cancel(Request $request, $id) {
        $appointment = $request->user()->reservations()->where('campaign_appointments.id', $id)->first();

        if ($appointment) {
            $appointment->pivot->delete();
        }

        return redirect('/appointments');
    }
}
