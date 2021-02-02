<?php

namespace App\Http\Controllers;

use App\Models\NurseProfile;
use App\Http\Resources\NurseProfile as NurseRes;
use App\Models\PatientProfile;
use App\Http\Resources\PatientProfile as PatientRes;
use App\Models\Quiz;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\User;
use App\Models\UserLog;
use App\Http\Resources\UserLog as UserLogRes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function listUnApprovedNurse()
    {
        $nurses = NurseProfile::where('is_approved', false)->get();

        return NurseRes::collection($nurses);
    }

    public function approveNurse(Request $request)
    {

            $nurse = NurseProfile::find($request->id);
            $nurse->is_approved = true;
            $nurse->save();


        return response()->json([
            'message' => 'nurse is approved',
        ]);
    }

    public function listApprovedNurse()
    {
        $nurses = NurseProfile::where('is_approved', true)->get();

        return NurseRes::collection($nurses);
    }

    public function listPatient(Request $request)
    {
        $patients = PatientProfile::all();

        $data = array();
        $i = 0;
        foreach ($patients as $patient) {
            if (!$patient->nurses || !$patient->nurses()->where('id', $request->id)) {
                $data[$i] = [
                    'id' => $patient->id,
                    'mother_name' => $patient->mother_name,
                ];
                $i++;
            }
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function listPatient2(Request $request)
    {
        $patients = PatientProfile::all();

        $data = array();
        $i = 0;
        foreach ($patients as $patient) {

                $data[$i] = [
                    'id' => $patient->id,
                    'baby_name' => $patient->baby_name,
                    'mother_name' => $patient->mother_name,
                ];
                $i++;

        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function listPatient3(Request $request)
    {
        $patients = PatientProfile::all();

        $data = array();
        $i = 0;
        foreach ($patients as $patient) {

                $data[$i] = [
                    'id' => $patient->id,
                    'name' => $patient->baby_name,
                ];
                $i++;

        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function searchPatient(Request $request)
    {
        return PatientRes::collection(
            PatientProfile::where('mother_name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('baby_name', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('father_name', 'LIKE', '%' . $request->keyword . '%')
                ->get()
        );
    }

    public function addRelation(Request $request)
    {
        $nurse = NurseProfile::find($request->nurse_id);

        foreach ($request->patients as $patient) {
            $nurse->patients()->attach($patient);
        }

        return response()->json([
            'message' => 'relation is created',
        ]);
    }

    public function removeRelation(Request $request)
    {
        $nurse = NurseProfile::find($request->nurse_id);


        $nurse->patients()->detach($request->patient_id);


        return response()->json([
            'message' => 'relation is removed',
        ]);
    }

    public function showPatient()
    { }

    public function destroyNurse(Request $request)
    {
        $nurse = NurseProfile::find($request->id);
        $user = $nurse->user;

        $nurse->patients()->detach();

        $user->delete();
        $nurse->delete();

        return response()->json([
            'message' =>  'nurse\'s data is deleted'
        ]);
    }
    public function showNurse(Request $request)
    {
        return new NurseRes(NurseProfile::find($request->id));
    }

    public function showNurseRelation(Request $request)
    {
        $nurse = NurseProfile::find($request->id);

        if (!$nurse->patients) return null;

        return response(PatientRes::collection($nurse->patients));
    }

    public function promoteAdmin(Request $request)
    {
        $user = User::find($request->id);

        if ($user->role_id == 10) {
            throw ValidationException::withMessages([
                'message' => 'user is not a nurse'
            ]);
        }

        if ($user->role_id == 21) {
            return response()->json([
                'message' => 'user is already an admin'
            ]);
        }

        $user->role_id = 21;
        $user->save();

        return response()->json([
            'message' => 'user is promoted to admin',
        ]);
    }

    public function demoteAdmin(Request $request)
    {
        $user = User::find($request->id);

        if ($user->role_id == 10) {
            throw ValidationException::withMessages([
                'message' => 'user is not a nurse'
            ]);
        }

        if ($user->role_id == 20) {
            return response()->json([
                'message' => 'user is already an nurse'
            ]);
        }

        $user->role_id = 20;
        $user->save();

        return response()->json([
            'message' => 'user is demoted to nurse',
        ]);
    }

    public function showDataSurvey()
    {
        $surveys = Survey::all();

        $color = ['#00f7ff', '#ff0000', '#ffd500', '#1bb525', '#1957bd'];
        $data = array();
        foreach ($surveys as $survey) {
            foreach ($survey->questions as $question) {
                for ($i = 0; $i<=4; $i++) {
                    $count = DB::table('patient_survey')->where([
//                        ['survey_id', $survey->id],
                        ['question_id', $question->id],
                        ['answer', $i+1]
                    ])->count();

                    $data[$i] = [
                        'name' => $i+1,
                        'choice_type' => $survey->choice_type,
                        'count' => $count,
                        'color' => $color[$i],
                        'legendFontColor'=> "#7F7F7F",
                        'legendFontSize'=> 15
                    ];

                }
                $data2[] = [
                    'question' => $question->question,
                    'jawaban' => $data
                ];
            }
            $data3[] = [
                'survey' => $survey->title,
                'pertanyaan' => $data2
            ];
        }

        return response($data3);
    }

    public function listQuiz(Request $request)
    {
        $quizzes = Quiz::all();
//        $patient = PatientProfile::find('id', $request->patient_id);

        $point = 0;
        $data = array();
        $i = 0;
        foreach ($quizzes as $quiz) {
            $answers = DB::table('user_answer')->where([
                ['patient_id', $request->patient_id],
                ['quiz_id', $quiz->id],
            ]);

            if ($answers->exists()) {
                foreach ($answers->get() as $answer) {
                    $point = $point + $answer->point;
                }
                $data[$i] = [
                    'quiz_id' => $quiz->id,
                    'quiz' => $quiz->title,
                    'total' => count($answers->get()),
                    'point' => $point,
                ];
                $i++;
                $point = 0;
            }
        }

        return response($data);
    }

    public function listSurvey(Request $request)
    {
        $surveys = Survey::all();

        $point = 0;
        $data = array();
        $n = 0;
        foreach ($surveys as $survey) {
            for ($i = 1; $i<=3; $i++) {
                $answers = DB::table('patient_survey')->where([
                    ['patient_id', $request->patient_id],
                    ['survey_id', $survey->id],
                    ['order', $i],
                ]);

                if ($answers->exists()) {
                    foreach ($answers->get() as $answer) {
                        $point = $point + $answer->point;
                    }
                    $data[$n] = [
                        'survey_id' => $survey->id,
                        'survey' => $survey->title,
                        'order' => $i,
                        'patient_id' => $request->patient_id,
                        'choice_type' => $survey->choice_type,
                        'point' => $point,
                    ];
                    $n++;
                    $point = 0;
                }
            }
        }
        return response()->json([
            'data' => $data,
        ]);
    }

    public function showSurvey(Request $request)
    {
        $patient = PatientProfile::find($request->patient_id);
        $surveys = $patient->surveys;

        $data = array();
        $i = 0;
        foreach ($surveys as $survey) {
            if ($survey->pivot->survey_id == $request->survey_id && $survey->pivot->order == $request->order) {
                $data[$i] = [
                    'question' => $survey->question,
                    'answer' => $survey->pivot->answer,
                ];
                $i++;
            }

        }

        return response($data);
    }

    public function showUserLog(Request $request)
    {
        $userLog = UserLog::orderBy('created_at', 'desc')
            ->limit($request->limit)
            ->get();

        return UserLogRes::collection($userLog);
    }
}
