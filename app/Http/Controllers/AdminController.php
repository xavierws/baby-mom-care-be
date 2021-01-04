<?php

namespace App\Http\Controllers;

use App\Models\NurseProfile;
use App\Http\Resources\NurseProfile as NurseRes;
use App\Models\PatientProfile;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function listUnApprovedNurse()
    {
        $nurses = NurseProfile::where('is_approved', false)->get();

        return NurseRes::collection($nurses);
    }

    public function approveNurse(Request $request)
    {
        foreach ($request->id as $id) {
            $nurse = NurseProfile::find($id);
            $nurse->is_approved = true;
            $nurse->save();
        }

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
            if (!$patient->nurses || $patient->nurses->id != $request->id) {
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

    public function showPatient()
    {

    }

    public function showDataSurvey()
    {
        $surveys = Survey::all();

        $color = ['#00f7ff', '#ff0000', '#ffd500', '#1bb525', '#1957bd'];
        $data = array();
        foreach ($surveys as $survey) {
            for ($i = 0; $i<=4; $i++) {
                $count = DB::table('patient_survey')->where([
                    ['survey_id', $survey->id],
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
        }

        return response($data);
    }
}
