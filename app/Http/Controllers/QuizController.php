<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Resources\Quiz as QuizRes;

class QuizController extends Controller
{
    public function show(Request $request)
    {
        return new QuizRes(Quiz::find($request->id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materi_id' => 'required',
            'title' => 'required',
            //'data.*.question' => 'required',
            //'data.*.choice1' => 'required',
            //'data.*.choice2' => 'required',
            //'data.*.choice3' => 'required',
        ]);

        Quiz::create([
            'title' => $request->input('title'),
            'materi_id' => $request->input('materi_id'),
        ]);

        $quizId = Quiz::orderBy('id', 'desc')->pluck('id')->first();
        $i = 0;
        foreach ($request->questions as $question) {
            Question::create([
                'question' => $question,
                'quiz_id' => $quizId,
            ]);

            $questionId = Question::orderBy('id', 'desc')->pluck('id')->first();
            QuestionChoice::create([
                'choice' => $request->choice1[$i],
                'is_true' => $request->is_true[$i] == "choice1" ? 1 : 0,
                'question_id' => $questionId,
            ]);

            QuestionChoice::create([
                'choice' => $request->choice2[$i],
                'is_true' => $request->is_true[$i] == "choice2" ? 1 : 0,
                'question_id' => $questionId,
            ]);
            QuestionChoice::create([
                'choice' => $request->choice3[$i],
                'is_true' => $request->is_true[$i] == "choice3" ? 1 : 0,
                'question_id' => $questionId,
            ]);

            $i++;
        }

        return response()->json([
            'message' => 'quiz is created',
        ]);
    }

    public function edit()
    { }

    public function delete()
    { }

    public function storeAnswer(Request $request)
    {
        $request->validate([]);

        $user = $request->user();

        foreach ($request->answers as $answer) {
            $choice = QuestionChoice::find($answer);
            $choice->patients()->attach($user->userable_id, [
                'point' => $choice->is_true ? 1 : 0,
                'question_id' => $choice->question_id,
                'quiz_id' => $choice->question->quiz_id,
            ]);
        }
        return response()->json([
            'message' => 'quiz is created',
        ]);
    }

    public function showAnswer(Request $request)
    {
        $user = $request->user();

        $quizzes = $user->userable->quizzes;

        $data = array();
        $point = 0;
        $i = 0;
        foreach ($quizzes as $quiz) {
            if ($quiz->pivot->quiz_id == $request->quiz_id) {
                $data[$i] = [
                    'question' => Question::find($quiz->question_id)->value('question'),
                    'point' => $quiz->pivot->point,
                ];
                $i++;
                $point = $point + $quiz->pivot->point;
            }
        }

        return response()->json([
            'data' => $data,
            'total_question' => $i,
            'total_point' => $point,
        ]);
    }

    public function showStatus(Request $request)
    {
        $patient = $request->user()->userable;
        $a = Materi::find($request->id);
        if ($a->quiz) {
            $quizId = $a->quiz->id;
            $status = 0;
            $data = array();
            $point = 0;
            $i = 0;
            foreach ($patient->quizzes as $quiz) {
                if ($quiz->pivot->quiz_id == $quizId) {
                    $i++;
                    $point = $point + $quiz->pivot->point;
                    $status = 1;
                }
            }

            return response()->json([
                'status' => $status,
                'total_question' => $i,
                'total_point' => $point,
            ]);
        } else {
            return response()->json([
                'status' => "not_available",
            ]);
        }
    }
}
