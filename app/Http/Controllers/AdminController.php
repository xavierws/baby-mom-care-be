<?php

namespace App\Http\Controllers;

use App\Models\NurseProfile;
use App\Http\Resources\NurseProfile as NurseRes;
use Illuminate\Http\Request;

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

    public function addRelation(Request $request)
    {

    }

    public function listPatient()
    {

    }

    public function showPatient()
    {

    }
}
