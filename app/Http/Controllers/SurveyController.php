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
        $data = $survey->url;

        if ($survey->choice_type !== 'link') {
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
        }

        return response()->json([
            'instruction' => $survey->instruction,
            'data' => $data
        ]);
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
            'url' => $request->input('url', null),
            'instruction' => $request->input('instruction', null),
//            'choice_type' => $request->choice[$i]
        ]);
        $survey_id = Survey::orderBy('id', 'desc')->pluck('id')->first();

        if ($request->input('choice_type') !== 'link') {
            $i = 0;
            foreach ($request->questions as $question) {
                SurveyQuestion::create([
                    'question' => $question,
                    'survey_id' => $survey_id,
                    'number' => $i+1,
                ]);
                $i++;
            }
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
        $survey->url = $request->input('url');
        $survey->instruction = $request->input('instruction');
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

//        $answers = json_decode($request->json(), true);
        foreach ($request->input('answers.*') as $v) {
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
                    'message' => 'patient already fill 3 times',
                    'errors'=>1
                ]);
            }

            $question = SurveyQuestion::find($v['id']);
//            $patient = $user->userable;
//            if ($question->patients->contains($patient)) {
//
//            }

            if ($question->survey_id == 1) {
                // perceived stress scale
                $val = $v['value'];
                if ($question->number == 2 || $question->number == 4 || $question->number == 5 || $question->number == 10) {
                    $point = ReversePoint::PSS($val);
                } else {
                    $point = $val;
                }
            } elseif ($question->survey_id == 2) {
                // Maternal Confidence Scale
                $val = $v['value'] + 1;
                if ($question->number == 10 || $question->number == 12) {
                    $point = ReversePoint::MCS($val);
                } else {
                    $point = $val;
                }
            } elseif ($question->survey_id == 3) {
                //Parental Stress scale
                $val = $v['value'] + 1;
                if (
                    $question->number == 1 ||
                    $question->number == 2 ||
                    $question->number == 5 ||
                    $question->number == 6 ||
                    $question->number == 7 ||
                    $question->number == 8 ||
                    $question->number == 17 ||
                    $question->number == 18
                ) {
                    $point = ReversePoint::MCS($val);
                } else {
                    $point = $val;
                }
            } else {
                $val = $v['value'];
                $point = $val;
            }

            $question->patients()->attach($user->userable_id, [
                'answer' => $val,
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
