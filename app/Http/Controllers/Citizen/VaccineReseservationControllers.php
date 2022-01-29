<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VaccineReseservationControllers extends Controller
{
    public function index() {
        return view('staff.campaign_clerk.index');
    }
}
