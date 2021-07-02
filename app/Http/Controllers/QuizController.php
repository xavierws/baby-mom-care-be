<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Resources\Quiz as QuizRes;
use Illuminate\Support\Facades\DB;

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

//        DB::table('user_answer')->where('')

        foreach ($request->answers as $answer) {
            $choice = QuestionChoice::find($answer);
            $question = $choice->question;
            $oldAnswer = DB::table('user_answer')
                ->where('patient_id', $user->userable_id)
                ->where('question_id', $question->id);

            if ($oldAnswer->get()->isEmpty()) {
                $order = 1;
            } else {
//                $n = 0;
//                $arr = array();
//                foreach ($oldAnswer as $o) {
//                    $arr[$n] = $o->pivot->order === null? 0:$o->pivot->order;
//                    $n++;
//                }
//                rsort($arr);
//                $order = $arr[0] + 1;
                $order = $oldAnswer->max('order') + 1;
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
//        $user = $request->user();
//
//        $quizzes = $user->userable->with(['quizzes' => function ($query) {
//            $query->groupBy('quiz_id');
//        }])->get();
//
//        $order = $quizzes->where('quiz_id', $request->quiz_id)->orderBy('order', 'desc')->first();
//
//        $data = array();
//        $point = 0;
//        $i = 0;
//        foreach ($quizzes as $quiz) {
//            if ($quiz->pivot->quiz_id == $request->quiz_id && $quiz->pivot->order == $order) {
//                $data[$i] = [
//                    'question' => Question::find($quiz->question_id)->question,
//                    'point' => $quiz->pivot->point,
//                ];
//                $i++;
//                $point = $point + $quiz->pivot->point;
//            }
//        }

        if ($request->has('order')) {
            $order = $request->order;
        } else {
            $order = DB::table('user_answer')
                ->where('quiz_id', $request->quiz_id)
                ->max('order');
        }


        $quizzes = DB::table('user_answer')
            ->where('quiz_id', $request->quiz_id)
            ->where('order', '=', $order)
            ->orderBy('question_id')
            ->get();

        $data = array();
        $point = 0;
        $i = 0;
        $status = 0;
        if ($quizzes->isNotEmpty()) {
            foreach ($quizzes as $quiz) {
                $data[$i] = [
                    'question' => Question::findOrFail($quiz->question_id)->question,
                    'point' => $quiz->point,
                ];
                $i++;
                $point = $point + $quiz->point;
            }
            $status = 1;
        }

        return response()->json([
            'data' => $data,
            'total_question' => $i,
            'total_point' => $point,
            'status' => $status,
        ]);
    }

    public function showStatus(Request $request)
    {
        $patient = $request->user()->userable;
        $materi = Materi::with('quiz')->find($request->id);
        if ($materi->quiz) {
//            $quizId = $materi->quiz->id;
//            $status = 0;
//            $data = array();
//            $point = 0;
//            $i = 0;
//            foreach ($patient->quizzes as $quiz) {
//                if ($quiz->pivot->quiz_id == $quizId) {
//                    $i++;
//                    $point = $point + $quiz->pivot->point;
//                    $status = 1;
//                }
//            }
//
//            return response()->json([
//                'status' => $status,
//                'total_question' => $i,
//                'total_point' => $point,
//            ]);
            $maxOrder = DB::table('user_answer')
                ->where('quiz_id', $materi->quiz->id)
                ->max('order');

            $quizzes = DB::table('user_answer')
                ->where('quiz_id', $materi->quiz->id)
                ->where('order', '=', $maxOrder)
                ->orderBy('question_id')
                ->get();

            $data = array();
            $point = 0;
            $i = 0;
            $status = 0;
            if ($quizzes->isNotEmpty()) {
                foreach ($quizzes as $quiz) {
                    $data[$i] = [
                        'question' => Question::find($quiz->question_id)->question,
                        'point' => $quiz->point,
                    ];
                    $i++;
                    $point = $point + $quiz->point;
                }
                $status = 1;
            }


            return response()->json([
                'data' => $data,
                'total_question' => $i,
                'total_point' => $point,
                'status' => $status,
            ]);
        } else {
            return response()->json([
                'status' => "not_available",
            ]);
        }
    }

    public function showHistory(Request $request)
    {
        $quiz_id = null;
        if ($request->has('materi_id')) {
            $materi = Materi::with('quiz')->find($request->id);
            $quiz_id = $materi->quiz->id;
        }

        if ($request->has('quiz_id')) {
            $quiz_id = $request->quiz_id;
        }

        $order = DB::table('user_answer')
            ->where('quiz_id', '=', $quiz_id)
            ->distinct()
            ->orderByDesc('order')
            ->pluck('order');

        $data = array();
        $i = 0;
        foreach ($order as $row) {
            $points = DB::table('user_answer')
                ->where('order', $row)
                ->where('quiz_id', $quiz_id)
                ->pluck('point');

            $score = 0;
            foreach ($points as $point) {
                $score += $point;
            }

            $data[$i] = [
                'order' => count($order)-$i,
                'quiz_id' => $quiz_id,
                'point' => $score,
                'total' => count($points)
            ];
            ++$i;
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
