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
        $appointments = $request->user()
            ->reservations()
            ->where('campaign_appointments.status', '!=', 'cancelled')
            ->where('campaign_appointments.status', '!=', 'finished')
            ->orderBy('date', 'asc')
            ->paginate(10);

        return view('citizen.appointments')->with('appointments', $appointments);
    }

    public function cancel(Request $request, $id) {
        $appointment = $request->user()->reservations()->where('campaign_appointments.id', $id)->first();

        if ($appointment) {
            $appointment->pivot->update([
                'status' => 'cancelled'
            ]);
        }

        return redirect('/appointments');
    }
}
