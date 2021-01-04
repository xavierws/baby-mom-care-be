<?php

namespace App\Http\Controllers;

use App\Http\Resources\NurseProfile as NurseRes;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function listNurse(Request $request)
    {
        $patient = $request->user()->userable;

        return NurseRes::collection($patient->nurses);
    }
}
