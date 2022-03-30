<?php

namespace App\Http\Controllers\Staff;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MoiaController extends Controller
{
    public function index() {
        $campaigns = Campaign::where('start_date', '>', now())->paginate(10);

        return view('moia.moia-escorting')
            ->with('campaigns', $campaigns);
    }
}
