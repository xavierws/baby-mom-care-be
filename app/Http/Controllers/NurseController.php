<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserRes;
use App\Models\NurseProfile;
use App\Models\PatientProfile;
use Illuminate\Http\Request;
use App\Http\Resources\PatientProfile as PatientRes;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $user = $patient->user;

        $patient->nurses()->detach();

        $user->delete();
        $patient->delete();

        return response()->json([
            'message' => 'patient is deleted'
        ]);
    }

    public function searchPatient(Request $request)
    {
        $nurseId = $request->user()->userable_id;
        $patients = NurseProfile::find($nurseId)->patients;
        //            ->where('mother_name', 'LIKE', '%' . $request->keyword . '%')
        //            ->orWhere('baby_name', 'LIKE', '%' . $request->keyword . '%')
        //            ->orWhere('father_name', 'LIKE', '%' . $request->keyword . '%')
        //            ->get();

        //        $patient = DB::table('nurse_profiles')
        //            ->join('nurse_patient', 'nurse_patient.nurse_id', '=', 'nurse_profiles.id')
        //            ->join('patient_profiles', 'nurse_patient.patient_id', '=', 'patient_profiles.id')
        //            ->where('nurse_profiles.id', '=', $nurseId)
        //            ->where('mother_name', 'LIKE', '%' . $request->keyword . '%')
        //            ->orWhere('baby_name', 'LIKE', '%' . $request->keyword . '%')
        //            ->orWhere('father_name', 'LIKE', '%' . $request->keyword . '%')
        //            ->get();

        $data = array();
        $i = 0;
        foreach ($patients as $patient) {
            if ($request->keyword) {
                if (
                    stripos($patient->mother_name, $request->keyword) !== false ||
                    stripos($patient->baby_name, $request->keyword) !== false ||
                    stripos($patient->father_name, $request->keyword) !== false
                ) {
                    $data[$i] = [
                        'id' => $patient->id,
                        'mother_name' => $patient->mother_name,
                        'baby_name' => $patient->baby_name,
                        'born_weight' => $patient->born_weight,
                        'user_id' => $patient->user->id,
                    ];
                    $i++;
                }
            }
        }

        return response($data);
    }

    public function update(Request $request)
    {
        $nurse = NurseProfile::find($request->id);
        $nurse->name = $request->name;
        if ($request->password) {
            $nurse2 = User::find($nurse->user->id);
            $nurse2->password = Hash::make($request->password);
            $nurse2->save();
        }
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
