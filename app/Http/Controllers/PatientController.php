<?php

namespace App\Http\Controllers;

use App\Http\Resources\NurseProfile as NurseRes;
use App\Models\NurseProfile;
use App\Models\PatientProfile;
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

    public function update(Request $request)
    {
//        $user = $request->user();

        $patient = PatientProfile::find($request->id);
        $patient->baby_name = $request->baby_name;
        $patient->baby_birthday = $request->baby_birthday;
        $patient->born_weight = $request->born_weight;
        $patient->born_length = $request->born_length;
        $patient->lingkar_kepala = $request->lingkar_kepala;
        $patient->baby_gender = $request->baby_gender;
        $patient->usia_gestas = $request->usia_gestas;
        $patient->harapan_orangtua = $request->harapan_orangtua;
        $patient->mother_name = $request->mother_name;
        $patient->mother_birthday = $request->mother_birthday;
        $patient->mother_religion = $request->mother_religion;
        $patient->mother_education = $request->mother_education;
        $patient->mother_job = $request->mother_job;
        $patient->paritas = $request->paritas;
        $patient->jumlah_anak = $request->jumlah_anak;
        $patient->pengalaman_merawat = $request->pengalaman_merawat;
        $patient->tinggal_dengan_suami = $request->tinggal_dengan_suami;
        $patient->father_name = $request->father_name;
        $patient->father_birthday = $request->father_birthday;
        $patient->father_name = $request->father_name;
        $patient->father_religion = $request->father_religion;
        $patient->father_education = $request->father_education;
        $patient->father_job = $request->father_job;
        $patient->pendapatan_keluarga = $request->pendapatan_keluarga;
        $patient->phone = $request->phone;
        $patient->save();

        return response()->json([
            'message' => 'patient\'s data is updated'
        ]);
    }
}
