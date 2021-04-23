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
    public function index()
    {
        return Quiz::all();
    }

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

    public function delete(Request $request)
    {
        $quiz = Quiz::find($request->input('id'));

        foreach ($quiz->choices as $choice) {
            $choice->delete();
        }

        foreach ($quiz->questions as $question) {
            $question->delete();
        }

        $quiz->delete();

        return response()->json([
            'message' => 'quiz is deleted'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([

            'title' => 'required',
            //'data.*.question' => 'required',
            //'data.*.choice1' => 'required',
            //'data.*.choice2' => 'required',
            //'data.*.choice3' => 'required',
        ]);

        $quizId = Quiz::find($request->quizId);
        $quizId->title = $request->title;
        $quizId->save();
        $i = 0;

        foreach ($request->questions as $question) {
            $soalId = Question::find($request->questionId[$i]);
            $soalId->question = $question;
            $soalId->save();

            $soal1 = QuestionChoice::find($request->choice1Id[$i]);
            $soal1->choice = $request->choice1[$i];
            $soal1->save();
            $soal2 = QuestionChoice::find($request->choice2Id[$i]);
            $soal2->choice = $request->choice2[$i];
            $soal2->save();
            $soal3 = QuestionChoice::find($request->choice3Id[$i]);
            $soal3->choice = $request->choice3[$i];
            $soal3->save();

            $i++;
        }

        return response()->json([
            'message' => 'quiz is updated',
        ]);
    }

    public function search(Request $request)
    {
        return Quiz::where('title', 'LIKE', '%' . $request->keyword . '%')->get();
    }

    public function storeAnswer(Request $request)
    {
        $request->validate([]);

        $user = $request->user();

        foreach ($request->answers as $answer) {
            $choice = QuestionChoice::find($answer);
            $oldAnswer = $choice->patients;

            if ($oldAnswer) {
                $n = 0;
                $arr = [];
                foreach ($oldAnswer as $o) {
                    $arr[$n] = $o->pivot->order;
                    $n++;
                }
                rsort($arr);
                $order = $arr[0] + 1;
            } else {
                $order = 1;
            }
            $choice->patients()->attach($user->userable_id, [
                'point' => $choice->is_true ? 1 : 0,
                'question_id' => $choice->question_id,
                'quiz_id' => $choice->question->quiz_id,
                'order' => $order,
            ]);
        }
        return response()->json([
            'message' => 'quiz is created',
        ]);
    }

    public function showAnswer(Request $request)
    {
        $user = $request->user();

        $quizzes = $user->userable->with(['quizzes' => function ($query) {
            $query->groupBy('quiz_id');
        }])->get();

        $order = $quizzes->where('quiz_id', $request->quiz_id)->orderBy('order', 'desc')->first();

        $data = array();
        $point = 0;
        $i = 0;
        foreach ($quizzes as $quiz) {
            if ($quiz->pivot->quiz_id == $request->quiz_id && $quiz->pivot->order == $order) {
                $data[$i] = [
                    'question' => Question::find($quiz->question_id)->question,
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
