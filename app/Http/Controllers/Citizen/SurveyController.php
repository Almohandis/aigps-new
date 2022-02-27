<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;

class SurveyController extends Controller
{
    public function index(Request $request) {
        if ($request->user()->survey()->exists()) {
            return redirect('/');
        }

        return view('citizen.survey')->with([
            'survey'    =>  $request->user()->survey()->create(),
        ]);
    }

    public function survey(Request $request) {
        if ($request->user()->survey()->exists()) {
            return redirect('/');
        }

        $request->validate([
            'question1' => 'required',
            'question2' => 'required',
            'question3' => 'required',
            'question4' => 'required',
        ]);

        $survey = $request->user()->survey()->create([
            'question1' => $request->question1,
            'question2' => $request->question2,
            'question3' => $request->question3,
            'question4' => $request->question4,
        ]);

        return redirect('/');
    }
}
