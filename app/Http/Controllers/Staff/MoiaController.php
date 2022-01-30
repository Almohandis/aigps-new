<?php

namespace App\Http\Controllers\Staff;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MoiaController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('start_date', '>', now())->get();
        return view('moia.moia-escorting', compact('campaigns'));
    }

    public function modify(Request $request)
    {
        $campaignStatus = $request->input('status');
        $campaignId = $request->query('id');

        if ($campaignStatus == 'Escort') {
            $status = Campaign::where('id', $campaignId)->update(['status' => 'active']);
        } else {
            $status = Campaign::where('id', $campaignId)->update(['status' => 'pending']);
        }
        echo $status;
    }
}
