<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\PatientProfile;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Quiz;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        foreach($request->input('question.*') as $question) {
            if ($question != null){
                $q = Question::create([
                    'question' => $question,
                    'quiz_id' => $quiz->id,
                ]);
                $j=1;
                foreach($request->input('choice.'.$i.".*") as $choice) {
                    QuestionChoice::create([
                        'choice' => $choice,
                        'is_true' => $request->input('choice.true.'.$i)==$j? 1:0,
                        'question_id' => $q->id,
                    ]);
                    $j++;
                }
                ++$i;
            }
        }

        return redirect()->route('kuis.show', $id)->with('message', 'success');
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $questions = Question::with('choices')->where('quiz_id', $quiz->id)->orderBy('id')->get();

        if (!$questions) {
            $questions == null;
        }
        return view('dashboard.kuis-edit')->with(compact('quiz', 'questions', 'id'));

        // dd($questions);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $i=1;
        foreach($quiz->questions as $question) {

            $question->question = $request->input('question.'.$i);
            $question->save();

            $j = 1;

            foreach($question->choices as $choice){
                $choice->choice = $request->input('choice.'.$i.'.'.$j);
                $choice->is_true = $request->input('choice.true.'.$i) == $j? 1:0;
                $choice->save();
                $j++;
            }

            $i++;
            $j=1;
        }

        $k = $request->has('numbQ')? $request->input('numbQ'):1;
        if ($request->has('question.new')) {
            foreach ($request->input('question.new.*') as $q) {
                $question = Question::create([
                    'question' => $q,
                    'quiz_id' =>$quiz->id,
                ]);

                $l=1;
                foreach($request->input('choice.new.'.$k.'.*') as $c) {
                    QuestionChoice::create([
                        'choice' => $c,
                        'is_true' => $request->input('choice.new.true.'.$k)==$l? 1:0,
                        'question_id' => $question->id,
                    ]);
                    $l++;
                }
                ++$k;
            }
        }

        $id = $quiz->materi->id;
        return redirect()->route('kuis.show', $id)->with('message', 'success');

        // $i=1;
        // $j=1;
        // $param = 'question.'.$i;
        // return $request->input($param);

    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        foreach ($question->choices as $choice) {
            $choice->delete();
        }

        $question->delete();

        return redirect()->back();
    }

    public function indexSurvey()
    {
        $survey = Survey::all();
        return view('dashboard.survey.list-survey')->with('survey', $survey);
    }

    public function showSurvey($id)
    {
        $survey = Survey::findOrFail($id);
        $questions = $survey->questions;

        return view('dashboard.survey.survey-show')->with(['survey' => $survey, 'questions' => $questions, 'id' => $id]);
    }

    public function createSurvey()
    {
        return view('dashboard.survey.survey-create');
    }

    public function storeSurvey(Request $request)
    {
        $url = $request->has('url')? $request->input('url'):null;

        $survey = Survey::create([
            'title' => $request->input('title'),
            'choice_type' => $request->input('choice_type'),
            'url' =>  $url,
        ]);

        $i=1;
        if ($request->has('question.*')) {
            foreach($request->input('question.*') as $question) {
                SurveyQuestion::create([
                    'question' => $question,
                    'survey_id' => $survey->id,
                    'number' => $i,
                ]);
                $i++;
            }
        }


        return redirect()->route('survey.index')->with('message', 'success');
    }

    public function editSurvey($id)
    {
        $survey = Survey::findOrFail($id);
        $questions = $survey->questions;

        return view('dashboard.survey.survey-edit')->with(compact('survey', 'questions', 'id'));
    }

    public function updateSurvey(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);

        $i = 1;
        foreach($survey->questions as $question) {
            $question->question = $request->input('question.'.$i);
            $question->save();
            $i++;
        }

        $k = $request->has('numbQ')? $request->input('numbQ'):1;
        if ($request->has('question.new')) {
            foreach ($request->input('question.new.*') as $q) {
                $question = SurveyQuestion::create([
                    'question' => $q,
                    'survey_id' => $survey->id,
                    'number' => $k,
                ]);
                ++$k;
            }
        }

        return redirect()->route('survey.show', $id)->with('message', 'success');
    }

    public function destroySurvey($id)
    {
        $survey = Survey::findOrFail($id);

        foreach ($survey->questions as $question) {
            $question->delete();
        }

        $survey->delete();
        return redirect()->back();
    }

    public function destroySurveyQ($id)
    {
        SurveyQuestion::findOrFail($id)->delete();
        return redirect()->back();
    }

    public function dumpLogData()
    {
        $userLog = UserLog::with(['user'])->orderBy('created_at', 'desc')->get();

        return view('dashboard.userlog.user-log')->with('userlog', $userLog);
    }

    public function showPatient()
    {
        $user = User::with('userable')->where('role_id', 10)->get();
        return view('dashboard.patient.patient-show')->with('user', $user);
    }

    public function showNurse()
    {
        $user = User::with('userable')->where([
            ['role_id', 20],
            ['role_id', 21],
            ['role_id', 22]
        ])->get();

        return view('dashboard.nurse.nurse-show')->with('user', $user);
    }

    public function dumpUserSurvey()
    {
        // $patients = PatientProfile::with(['surveys' => function($query) {
        //     $query->orderBy('survey_id');
        // }]);
        // $survey = Survey::all();

        // $data = [];
        // foreach ($patients as $patient) {
        //     if (condition) {
        //         # code...
        //     }
        //     $data[] = [
        //         'name' => $patient->mother_name,
        //         ''
        //     ];
        // }

        $answers = DB::table('patient_survey')->get();

        $data = array();
        $i = 1;
        foreach ($answers as $answer) {
            $data[$i] = [
                'patient_id' => $answer->patient_id,
                'name' => PatientProfile::find($answer->patient_id)->value('mother_name'),
                'survey_id' => $answer->survey_id,
                'survey_title' => Survey::find($answer->survey_id)->value('title'),
                'order' => $answer->order
            ];
            $i++;
        }
        return view('dashboard.userSurvey.user-survey')->with(['patients' => $data]);
    }

    public function showUserSurvey($id, $order)
    {
        $answers = DB::table('patient_survey')
        ->where('patient_id', $id)
        ->where('order', $order)
        ->get();

        $patient = PatientProfile::find($id);
        $data = array();
        foreach ($answers as $answer) {
            $data[$answer->question_id] = [
                'question' => SurveyQuestion::find($answer->question_id),
                'ans' => $answer->$answer,
                'point' => $answer->point,
            ];
        }

        return view('dashboard.userSurvey.survey-detail')->with(['patient' => $patient, 'data' => $data]);
    }
}
