<?php

namespace App\Http\Controllers;

use App\Models\NurseProfile;
use App\Models\PatientProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',

            'nurse_id' => 'required_if:role,patient',
            'baby_name' => 'required_if:role,patient',
            'baby_birthday' => 'required_if:role,patient',
            'born_weight' => 'required_if:role,patient|integer',
            'born_length' => 'required_if:role,patient|integer',
            'baby_gender' => 'required_if:role,patient',
            'mother_name' => 'required_if:role,patient',
            'mother_birthday' => 'required_if:role,patient|date',
            'mother_religion' => 'required_if:role,patient',
            'mother_education' => 'required_if:role,patient',
            'mother_job' => 'required_if:role,patient',
            'paritas' => 'required_if:role,patient|integer',
            'father_name' => 'required_if:role,patient',
            'father_birthday' => 'required_if:role,patient|date',
            'father_religion' => 'required_if:role,patient',
            'father_education' => 'required_if:role,patient',
            'father_job' => 'required_if:role,patient',

            'nurse_name' => 'required_if:role,nurse',
            'working_exp' => 'required_if:role,nurse|integer',
            'education' => 'required_if:role,nurse',
            'phone' => 'required_if:role,nurse|integer',
            'hospital_id' => 'required_if:role,nurse|integer',
        ]);

        if ($request->role == 'nurse') {
            NurseProfile::create([
                'name' => $request->input('nurse_name'),
                'working_exp' => $request->input('working_exp'),
                'education' => $request->input(''),
                'phone' => $request->input('nurse_name'),
                'hospital_id' => $request->input('nurse_name'),
                'is_approved' => false,
            ]);

            $userable_id = NurseProfile::orderBy('id', 'desc')->pluck('id')->first();
            $userable_type = 'App\Models\NurseProfile';
        } elseif ($request->role == 'patient') {
            PatientProfile::create([
                'baby_name' => $request->input('baby_name'),
                'baby_birthday' => $request->input('baby_birthday'),
                'born_weight' => $request->input('born_weight'),
                'born_length' => $request->input('born_length'),
                'baby_gender' => $request->input('baby_gender'),
                'mother_name' => $request->input('mother_name'),
                'mother_birthday' => $request->input('mother_birthday'),
                'mother_religion' => $request->input('mother_religion'),
                'mother_education' => $request->input('mother_education'),
                'mother_job' => $request->input('mother_job'),
                'paritas' => $request->input('paritas'),
                'father_name' => $request->input('father_name'),
                'father_birthday' => $request->input('father_birthday'),
                'father_religion' => $request->input('father_religion'),
                'father_education' => $request->input('father_education'),
                'father_job' => $request->input('father_job'),
            ]);

            $userable_id = PatientProfile::orderBy('id', 'desc')->pluck('id')->first();
            $userable_type = 'App\Models\PatientProfile';

            NurseProfile::find($request->nurse_id)->patients()->attach($userable_id);
        }

        User::create([
            'role_id' => Role::where('name', $request->role)->value('id'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email', null),
            'userable_id' => $userable_id,
            'userable_type' => $userable_type,
        ]);

        return response()->json([
            'message' => 'account created',
            'id' => $userable_id,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'role' => $user->user_role,
        ]);
    }

    public function logout(Request $request)
    {
        $username = $request->user()->username()->first();
        User::where('username', $username)->tokens()->delete();

        return response()->json([
            'message' => 'logout successful'
        ]);
    }

    public function resetPassword()
    {

    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
