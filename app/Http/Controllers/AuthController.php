<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\NurseProfile;
use App\Models\PatientProfile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\User as UserRes;
use App\Models\NotificationLog;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|alpha_num',

//            'nurse_id' => 'required_if:role,patient',
            'baby_name' => 'required_if:role,patient',
            'baby_birthday' => 'required_if:role,patient',
            'born_weight' => 'required_if:role,patient',
            'born_length' => 'required_if:role,patient',
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
            //xav tambahin
            'usia_gestas' => 'required_if:role,patient', //int
            'harapan_orangtua' => 'required_if:role,patient', //yes/no
            'lingkar_kepala' => 'required_if:role,patient', //int
            'jumlah_anak' => 'required_if:role,patient', //lebih dari 2/kurang dari sama dengan 2
            'pendapatan_keluarga' => 'required_if:role,patient', //lebih dari 3jt/kurang dari sama dengan 3jt
            'pengalaman_merawat' => 'required_if:role,patient', //yes/no
            'tinggal_dengan_suami' => 'required_if:role,patient', //yes/no

            'nurse_name' => 'required_if:role,nurse',
            'working_exp' => 'required_if:role,nurse|integer',
            'education' => 'required_if:role,nurse',
            'phone' => 'required_if:role,nurse',
            'hospital_id' => 'required_if:role,nurse|integer',
        ]);

        if ($request->role == 'nurse') {
            NurseProfile::create([
                'name' => $request->input('nurse_name'),
                'working_exp' => $request->input('working_exp'),
                'education' => $request->input('education'),
                'phone' => $request->input('phone'),
                'hospital_id' => $request->input('hospital_id'),
                'is_approved' => true,
            ]);

            $userable_id = NurseProfile::orderBy('id', 'desc')->pluck('id')->first();
            $userable_type = 'App\Models\NurseProfile';
        } elseif ($request->role == 'patient') {
            $nurse = $request->user();
            PatientProfile::create([
                'baby_name' => $request->input('baby_name'),
                'baby_birthday' => $request->input('baby_birthday'),
                'born_weight' => $request->input('born_weight'),
                'born_length' => $request->input('born_length'),
                'lingkar_kepala' => $request->input('lingkar_kepala'),
                'baby_gender' => $request->input('baby_gender'),
                'usia_gestas' => $request->input('usia_gestas'),
                'harapan_orangtua' => $request->input('harapan_orangtua'),
                'mother_name' => $request->input('mother_name'),
                'mother_birthday' => $request->input('mother_birthday'),
                'mother_religion' => $request->input('mother_religion'),
                'mother_education' => $request->input('mother_education'),
                'mother_job' => $request->input('mother_job'),
                'paritas' => $request->input('paritas'),
                'jumlah_anak' => $request->input('jumlah_anak'),
                'pengalaman_merawat' => $request->input('pengalaman_merawat'),
                'tinggal_dengan_suami' => $request->input('tinggal_dengan_suami'),
                'father_name' => $request->input('father_name'),
                'father_birthday' => $request->input('father_birthday'),
                'father_religion' => $request->input('father_religion'),
                'father_education' => $request->input('father_education'),
                'father_job' => $request->input('father_job'),
                'pendapatan_keluarga' => $request->input('pendapatan_keluarga'),
                'phone' => $request->input('phone'),
                'status' => 'hospital',
                'hospital_id' => $nurse->userable->hospital_id,
            ]);

            $userable_id = PatientProfile::orderBy('id', 'desc')->pluck('id')->first();
            $userable_type = 'App\Models\PatientProfile';

            NurseProfile::find($nurse->userable_id)->patients()->attach($userable_id);

            NotificationLog::create([
                'notification' => 'Jangan lupa isi survey yang pertama',
                'nurse_id' => $userable_id,
                'type' => 'survey',
            ]);

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
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

//        $user->fcm_token = $request->input('fcm_token', null);
//        $user->save();

        return response()->json([
            'token' => $token,
            'username' => $user->username,
            'role' => $user->user_role
        ]);
    }

    public function logout(Request $request)
    {
        $username = $request->user()->username;
        User::where('username', $username)->first()->tokens()->delete();

        return response()->json([
            'message' => 'logout successful'
        ]);
    }

    public function resetPassword()
    { }

    public function user(Request $request)
    {
        $user = $request->user();

        UserLog::create([
            'log' => 'open homepage',
            'user_id' => $user->id,
        ]);

        return new UserRes($user);
    }

    public function showRegisterPage()
    {
        $hospitals = Hospital::all();

        return view('register', compact('hospitals'));
    }

    public function registerNurse(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|confirmed|alpha_num',
        ]);

        NurseProfile::create([
            'name' => $request->input('nurse_name'),
            'working_exp' => $request->input('working_exp'),
            'education' => $request->input('education'),
            'phone' => $request->input('phone'),
            'hospital_id' => $request->input('hospital_id'),
            'is_approved' => false,
        ]);

        $userable_id = NurseProfile::orderBy('id', 'desc')->pluck('id')->first();
        $userable_type = 'App\Models\NurseProfile';

        User::create([
            'role_id' => 20,
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email', null),
            'userable_id' => $userable_id,
            'userable_type' => $userable_type,
        ]);

        return redirect(route('register'))->with('status', 'Perawat berhasil register');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required',
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json([
            'message' => 'password is updated',
        ]);
    }
}
