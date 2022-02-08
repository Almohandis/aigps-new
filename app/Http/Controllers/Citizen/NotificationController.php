<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller {
    public function index(Request $request) {
        $notifications = $request->user()->notifications()->orderBy('created_at', 'DESC')->get();

        $request->user()->notifications()->where('read', false)->update(['read' => true]);

        return view('citizen.notifications')->with('notifications', $notifications);
    }
}
