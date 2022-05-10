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

    public function edit(Request $request, $id) {
        $appointment = $request->user()->reservations()->where('campaign_appointments.id', $id)->first();

        $start = Carbon::parse($appointment->start_date);
        $end = Carbon::parse($appointment->end_date);
        $date = Carbon::parse($request->date);

        if (! $date->between($start, $end)) {
            return back()->withErrors([
                'date' => 'Date is not within the campaign\'s time frame.'
            ]);
        }

        if ($appointment) {
            $appointment->pivot->update([
                'date' => $date
            ]);
        }

        return back()->withSuccess('Appointment updated successfully.');
    }
}
