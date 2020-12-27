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
            'data' => 'required|array',
        ]);

        foreach ($request->data as $data) {
            Survey::create([
                'title' => $request->input('title'),
                'question' => $data['question'],
                'choice_type' => $data['choice_type'],
            ]);
        }

        return response()->json([
            'message' => 'survey created'
        ]);
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function saveAnswer(Request $request)
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
