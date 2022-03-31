<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Question;

class SurveyController extends Controller
{
    public function index(Request $request) {
        if ($request->user()->hasSurvey()) {
            return redirect('/');
        }

        return view('citizen.survey')->with([
            'questions'     =>      Question::get()
        ]);
    }

    public function survey(Request $request) {
        if ($request->user()->hasSurvey()) {
            return back()->with('error', 'You have already completed the survey');
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        $answers = $request->input('answers');

        foreach ($answers as $questionId => $answer) {
            // remove all answers from this user
            $request->user()->answers()->detach($questionId);

            $request->user()->answers()->attach($questionId, ['answer' => $answer]);
        }

        return redirect('/');
    }
}
