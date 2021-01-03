<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserRes;
use App\Models\NurseProfile;
use App\Models\PatientProfile;
use Illuminate\Http\Request;
use App\Http\Resources\PatientProfile as PatientRes;

class NurseController extends Controller
{
    public function listPatient(Request $request)
    {
        $user = $request->user();

        $patients = NurseProfile::find($user->userable_id)->patients;
        return PatientRes::collection($patients);
    }

    public function showPatient(Request $request)
    {
        $patient = PatientProfile::find($request->id);
//        $user = $patient->user;

        return [new PatientRes($patient)];
    }
}
