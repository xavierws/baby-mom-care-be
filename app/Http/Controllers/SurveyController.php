<?php

namespace App\Http\Controllers;

use App\Actions\ReversePoint;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        return response(Survey::all());
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $survey = Survey::find($request->id);

        $data = array();
        $i = 0;
        foreach ($survey->questions as $question) {
            $data[$i] = [
                'id' => $question->id,
                'question' => $question->question,
                'number' => $question->number,
            ];
            $i++;
        }

        return response($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'choice_type' => 'required',
            //'datas' => 'required|array',
        ]);

        Survey::create([
            'title' => $request->input('title'),
            'choice_type' => $request->input('choice_type'),
//            'choice_type' => $request->choice[$i]
        ]);
        $survey_id = Survey::orderBy('id', 'desc')->pluck('id')->first();

        $i = 0;
        foreach ($request->questions as $question) {
            SurveyQuestion::create([
                'question' => $question,
                'survey_id' => $survey_id,
                'number' => $i+1,
            ]);
            $i++;
        }

        return response()->json([
            'message' => 'survey is created'
        ]);
    }

    public function edit()
    { }

    public function update(Request $request)
    {
//        foreach ($request->data as $data) {
//            $survey = Survey::find($data['id']);
//            $survey->title = $request->input('title');
//            $survey->question = $data['question'];
//            $survey->choice_type = $data['choice_type'];
//            $survey->save();
//        }

        $survey = Survey::find($request->id);
        $survey->title = $request->input('title');
        $survey->choice_type = $request->input('choice_type');
        $survey->save();

//        $question[] = $request->input('questions');
        $i = 0;
        foreach ($survey->questions as $question) {
            $question->question = $request->questions[$i];
            $question->save();
            $i++;
        }

        return response()->json([
            'message' => 'survey is updated',
        ]);
    }

    public function delete(Request $request)
    {
//        foreach ($request->data as $data) {
//            Survey::find($data['id'])->delete();
//        }

        $survey = Survey::find($request->id);

        foreach ($survey->questions as $question) {
            $question->delete();
        }
        $survey->delete();

        return response()->json([
            'message' => 'survey is deleted'
        ]);
    }

    public function storeAnswer(Request $request)
    {
        /*
        $request->validate([
            'data.*.id' => 'required',
            'data.*.answer' => 'required|integer',
        ]);
        */

        $user = $request->user();

        /*
        foreach ($request->data as $data) {
            Survey::find($data['id'])->patients()->attach($user->userable_id, ['answer' => $data['answer']]);
        }
        */

//        $i = 0;
//        $a = DB::table('patient_survey')->where('question_id', $request->id[$i]);
//        if ($a->exists()) {
//            $order = $a->orderBy('order', 'desc')->first()->order+1;
//        } else {
//            $order = 1;
//        }

//        $answers = json_decode($request->answers, true);
        foreach ($request->answers as $v) {
            $oldAnswer = DB::table('patient_survey')
                ->where('patient_id', $user->userable_id)
                ->where('question_id', $v['id']);

            if ($oldAnswer->get()->isEmpty()) {
                $order = 1;
            } else {
                $order = $oldAnswer->max('order') + 1;
            }

            if ($order > 3) {
                return response()->json([
                    'message' => 'patient already fill 3 times'
                ]);
            }

            $question = SurveyQuestion::find($v['id']);
//            $patient = $user->userable;
//            if ($question->patients->contains($patient)) {
//
//            }

            if ($v['id'] == 1) {
                if ($question->number == 2 || $question->number == 4 || $question->number == 5 || $question->number == 10) {
                    $point = ReversePoint::PSS($v['value']);
                } else {
                    $point = $v['value'];
                }
            } elseif ($v['id'] == 2) {
                if ($question->number == 10 || $question->number == 12) {
                    $point = ReversePoint::MCS($v['value']);
                } else {
                    $point = $v['value'];
                }
            } else {
                $point = $v['value'];
            }

            $question->patients()->attach($user->userable_id, [
                'answer' => $v['value'],
                'point' => $point,
                'order' => $order,
                'survey_id' => $question->survey_id,
            ]);


        }

//        foreach ($request->answers as $answer) {
//            $question = SurveyQuestion::find($request->id[$i]);
//            if ($question->survey_id == 1) {
//                if ($question->number == 2 || $question->number == 4 || $question->number == 5 || $question->number == 10) {
//                    $point = ReversePoint::PSS($answer);
//                } else {
//                    $point = $answer;
//                }
//            } elseif ($question->survey_id == 2) {
//                if ($question->number == 10 || $question->number == 12) {
//                    $point = ReversePoint::MCS($answer);
//                } else {
//                    $point = $answer;
//                }
//            } else {
//                $point = $answer;
//            }
//
//            $question->patients()->attach($user->userable_id, [
//                'answer' => $answer,
//                'point' => $point,
//                'order' => $order,
//                'survey_id' => $question->survey_id,
//            ]);
//            $i++;
//        }

        return response()->json([
            'message' => 'survey answers are stored',
        ]);
    }
}
