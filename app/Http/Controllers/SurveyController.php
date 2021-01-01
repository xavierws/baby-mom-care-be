<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        return response()->json([
           'title_1' => 'kuisioner_1',
           'title_2' => 'kuisioner_2'
        ]);
    }

    public function show(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $survey = Survey::where('title', $request->title)->get();

        return response($survey);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'datas' => 'required|array',
        ]);

        foreach ($request->datas as $data) {
            Survey::create([
                'title' => $request->input('title'),
                'question' => $data['question'],
                'choice_type' => $data['choice_type'],
            ]);
        }

        return response()->json([
            'message' => 'survey is created'
        ]);
    }

    public function edit()
    { }

    public function update(Request $request)
    {
        foreach ($request->data as $data) {
            $survey = Survey::find($data['id']);
            $survey->title = $request->input('title');
            $survey->question = $data['question'];
            $survey->choice_type = $data['choice_type'];
            $survey->save();
        }

        return response()->json([
            'message' => 'survey is updated',
        ]);
    }

    public function delete(Request $request)
    {
        foreach ($request->data as $data) {
            Survey::find($data['id'])->delete();
        }

        return response()->json([
            'message' => 'survey is deleted'
        ]);
    }

    public function storeAnswer(Request $request)
    {
        $request->validate([
            'data.*.id' => 'required',
            'data.*.answer' => 'required|integer',
        ]);

        $user = $request->user();

        foreach ($request->data as $data) {
            Survey::find($data['id'])->patients()->attach($user->userable_id, ['answer' => $data['answer']]);
        }

        return response()->json([
            'message' => 'survey answers are stored',
        ]);
    }
}
