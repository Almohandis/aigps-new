<?php

namespace App\Http\Controllers\Staff;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MoiaController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('start_date', '>', now())->paginate(10);

        return view('moia.moia-escorting', compact('campaigns'));
    }

    public function modify(Request $request)
    {
        $action = $request->query('action');
        $campaignId = $request->query('id');

        if ($action == 'Escort') {
            $status = Campaign::find($campaignId)->update(['status' => 'active']);
        } else {
            $status = Campaign::find($campaignId)->update(['status' => 'pending']);
        }
        echo $status;
    }
}
