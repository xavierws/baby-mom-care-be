<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Quiz;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $materi = Materi::all();
        return view('dashboard.list-materi')->with('materi', $materi);
    }

    public function show($id)
    {
        $quiz = Materi::findOrFail($id)->quiz;
        $questions = null;
        if ($quiz){
            $questions = Question::with('choices')->where('quiz_id', $quiz->id)->get();
            $id = $quiz->id;
        }

        // $data = array();
        // $i=0;
        // foreach ($questions as $question) {
        //     $choices = $question->choices;
        //     $data[$i] = [
        //         $choices,
        //     ];
        //     ++$i;
        // }


        return view('dashboard.kuis-show')->with(compact('quiz', 'questions', 'id'));
    }

    public function create($id)
    {
        return view('dashboard.kuis-create')->with('id', $id);
    }

    public function store(Request $request, $id)
    {
        $quiz = Quiz::create([
            'title' => Materi::find($id)->title,
            'materi_id' => $id,
        ]);

        $i=1;
        foreach($request->question as $question) {
            if ($question != null){
                $q = Question::create([
                    'question' => $question,
                    'quiz_id' => $quiz->id,
                ]);
                foreach($request->choice[$i] as $choice) {
                    QuestionChoice::create([
                        'choice' => $choice,
                        'is_true' => $choice == $request->choice[true][$i]? 1:0,
                        'question_id' => $q->id,
                    ]);
                }
                ++$i;
            }
        }

        return redirect()->route('kuis.create', $id)->with('message', 'success');
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $questions = Question::with('choices')->where('quiz_id', $quiz->id)->orderBy('id')->get();

        $i = 0;
        foreach($questions as $question){
            $data[$i]['question'] = $question->question;

            $k = 1;
            foreach($question->choices as $choice) {
                $data[$i]['choice'.$k] = $choice->choice;
                ++$k;
            }
            ++$i;
        }
        return view('dashboard.kuis-edit')->with(compact('quiz', 'questions', 'id', 'data'));

        // dd($questions);
    }

    public function update(Request $request, $id)
    {
        // $quiz = Quiz::updateOrCreate([
        //     'title' => Materi::find($id)->title,
        //     'materi_id' => $id,
        // ]);

        $quiz = Quiz::findOrFail($id);

        $i=1;
        foreach($quiz->questions as $question) {

            if ($question){
                $question->question = $request->input('question.'.$i);
                $question->save();
            } else {
                $question = Question::create([
                    'question' => $request->input('question.'.$i),
                    'quiz_id' => $id,
                ]);
            }


            $j = 1;

            // foreach($request->input('choice.'.$j.'.*') as $c){
            //     $choice = QuestionChoice::updateOrCreate([
            //         'choice' => $c,
            //         'is_true' => $request->input('choice.true.'.$i) == $j? 1:0,
            //         'question_id' => $question->id,
            //     ]);
            //     $j++;
            // }

            // if ($question->choices != null) {

            //     foreach($question->choices as $choice){
            //         $choice->choice = $request->input('choice.'.$i.'.'.$j);
            //         $choice->is_true = $request->input('choice.true.'.$i) == $j? 1:0;
            //         $choice->save();
            //         $j++;
            //     }
            // } else {

            //     foreach ($request->)
            //     $choice = QuestionChoice::create([
            //         'choice' => $request->input('choice.'.$i.'.'.$j),
            //         'is_true' => $request->input('choice.true.'.$i) == $j? 1:0,
            //         'question_id' => $question->id,
            //     ]);
            // }

            $i++;
            $j=1;
        }

        // foreach($request->question as $question) {
        //     if ($question != null){
        //         $q = Question::updateOrCreate([
        //             'question' => $question,
        //             'quiz_id' => $quiz->id,
        //         ]);
        //         foreach($request->choice as $choice) {
        //             QuestionChoice::updateOrCreate([
        //                 'choice' => $choice,
        //                 'is_true' => $choice == $request->choice[true][$i]? 1:0,
        //                 'question_id' => $q->id,
        //             ]);
        //         }
        //         ++$i;
        //     }
        // }

        $id = $quiz->materi->id;
        return redirect()->route('kuis.show', $id)->with('message', 'success');

        // $i=1;
        // $j=1;
        // $param = 'question.'.$i;
        // return $request->input($param);

    }
}
