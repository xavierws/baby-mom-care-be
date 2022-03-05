<?php

namespace App\Actions;

use App\Models\PatientProfile;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;

class ReformatSurvey
{
    public static function handle()
    {

    }

    public static function query($surveyId)
    {
//        $surveys = DB::table('patient_survey')->where('survey_id', $surveyId)->get();
//        $questions = Survey::find($surveyId)->questions;
//        $countQ = count($questions);
//
//        foreach ($surveys as $survey) {
//            for ()
//        }

        $patients = PatientProfile::has('surveys')->get();

//        foreach ($patients as $patient) {
//            $surveys = DB::table('patient_survey')
//                ->where('patient_id', $patient->id)
//                ->where('survey_id', $surveyId)
//                ->orderBy('order')
//                ->get();
//
//            $order = 1;
//            $n = 0;
//            $data = array();
//            foreach ($surveys as $survey) {
//                if ($survey->order == $order){
//                    $data[$n] =
//                }
//
//            }
//        }
    }
}
