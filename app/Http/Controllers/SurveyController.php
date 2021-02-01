<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
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

        $i = 0;
        $a = DB::table('patient_survey')->where('question_id', $request->id[$i]);
        if ($a->exists()) {
            $order = $a->orderBy('order', 'desc')->first()->order+1;
        } else {
            $order = 1;
        }
        foreach ($request->answers as $answer) {
            $question = SurveyQuestion::find($request->id[$i]);
            $question->patients()->attach($user->userable_id, [
                'answer' => $answer,
                'order' => $order,
                'survey_id' => $question->survey_id,
            ]);
            $i++;
        }

        return response()->json([
            'message' => 'survey answers are stored',
        ]);
    }
}
