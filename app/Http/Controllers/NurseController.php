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
        if ($request->id) {
            $user = $request->id;
        } else {
            $user = $request->user()->userable_id;
        }
        $patients = NurseProfile::find($user)->patients;
        return PatientRes::collection($patients);
    }

    public function showPatient(Request $request)
    {
        $patient = PatientProfile::find($request->id);
        $user = $patient->user;

        return new PatientRes($patient);
    }
    public function destroyPatient(Request $request)
    {
        $patient = PatientProfile::find($request->id);
        $patient->delete();

        return response()->json([
            'message' => 'patient is deleted'
        ]);
    }

    public function update(Request $request)
    {
        $nurse = NurseProfile::find($request->id);
        $nurse->name = $request->name;
        $nurse->working_exp = $request->working_exp;
        $nurse->education = $request->education;
        $nurse->phone = $request->phone;
        $nurse->hospital_id = $request->hospital_id;
        $nurse->save();

        return response()->json([
            'message' =>  'nurse\'s data is updated'
        ]);
    }
}
