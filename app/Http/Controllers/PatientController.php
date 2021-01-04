<?php

namespace App\Http\Controllers;

use App\Http\Resources\NurseProfile as NurseRes;
use App\Models\NurseProfile;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function listNurse(Request $request)
    {
        $patient = $request->user()->userable;

        return NurseRes::collection($patient->nurses);
    }
    public function showNurse(Request $request)
    {
        return new NurseRes(NurseProfile::find($request->id));
    }
}
