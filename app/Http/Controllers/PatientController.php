<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function listNurse(Request $request)
    {
        $patient = $request->user()->userable;

        return response($patient->nurses);
    }
}
