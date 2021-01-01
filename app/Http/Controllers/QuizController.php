<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'materi_id' => 'required',
            'title' => 'required',

            'data.*.question' => 'required',
            'data.*.choice1' => 'required',
            'data.*.choice2' => 'required',
            'data.*.choice3' => 'required',
        ]);

        Quiz::create([
            'title' => $request->input('title'),
            'materi_id' => $request->input('materi_id'),
        ]);

        $quizId = Quiz::orderBy('id', 'desc')->pluck('id')->first();
        foreach ($request->data as $data) {
            Question::create([
                'question' => $data['question'],
                'quiz_id' => $quizId,
            ]);

            $questionId = Question::orderBy('id', 'desc')->pluck('id')->first();
            QuestionChoice::create([
                'choice' => $data['choice1']['text'],
                'is_true' => $data['choice1']['is_true'],
                'question_id' => $questionId,
            ]);

            QuestionChoice::create([
                'choice' => $data['choice2']['text'],
                'is_true' => $data['choice2']['is_true'],
                'question_id' => $questionId,
            ]);

            QuestionChoice::create([
                'choice' => $data['choice3']['text'],
                'is_true' => $data['choice3']['is_true'],
                'question_id' => $questionId,
            ]);
        }

        return response()->json([
            'message' => 'quiz is created',
        ]);
    }

    public function edit()
    {

    }

    public function delete()
    {

    }

    public function storeAnswer()
    {

    }
}
