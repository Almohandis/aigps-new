<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;

class CampaignClerkController extends Controller
{
    public function index() {
        return view('staff.campaign_clerk.index');
    }
}
