<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\User;

class MohSurveyController extends Controller {
    public function index(Request $request) {
        $questions = Question::paginate(10);

        return view('moh.survey', [
            'questions' => $questions
        ]);
    }

    public function create(Request $request) {
        $request->validate([
            'title'         =>      ['required', 'string']
        ]);

        $question = new Question();
        $question->title = $request->title;
        $question->save();

        return back()->withSuccess('Question created successfully');
    }

    public function update(Request $request, Question $question) {
        $request->validate([
            'title'         =>      ['required', 'string']
        ]);

        $question->update([
            'title' => $request->title
        ]);

        return back()->withSuccess('Question updated successfully');
    }

    public function delete(Request $request, Question $question) {
        foreach($question->answers as $answer) {
            $answer->pivot->delete();
        }

        $question->delete();

        return back()->withSuccess('Question deleted successfully');
    }
}
