<?php

namespace App\Http\Controllers;

use App\Actions\CountFormula;
use App\Models\Image;
use App\Models\Kontrol;
use App\Models\PatientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Kontrol as KontrolRes;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class KontrolController extends Controller
{
    public function index(Request $request)
    {

        if ($request->id) {
            $pasien = $request->id;
        } else {
            $pasien = $request->user()->userable->id;
        }
        $patient = PatientProfile::find($pasien);
        $data = array();

        if ($patient) {
            $n = 0;
            foreach ($patient->kontrols->where('mode', 'kontrol') as $kontrol) {
                $data[$n] = [
                    'id' => $kontrol->id,
                    'date' => $kontrol->date,
                    'order' => $kontrol->order,
                    'note' => $kontrol->note,
                    'nurse_note' => $kontrol->nurse_note
                ];
                $n++;
            }
        }
        return response()->json([
            'data' => $data
        ]);
    }

    public function search()
    { }

    public function show(Request $request)
    {
        return new KontrolRes(Kontrol::find($request->id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'tempat_kontrol' => 'required',
            'weight' => 'required',
            'length' => 'required',
            'lingkar_kepala' => 'required',
            'temperature' => 'required',
            'base64_img' => 'required',
            'mode' => 'required'
        ]);

        $user = $request->user();
        if ($user->user_role == 'nurse') {
            $patientId = $request->input('patient_id');
        } else {
            $patientId = $user->userable->id;
        }
        $a = Kontrol::where('mode', 'resume')->where('patient_profile_id', $patientId)->first();
        if ($a) {
            if ($request->input('mode') == "resume") {
                return response()->json([
                    'errors' => 'asdassad',
                    'message' => 'resume tidak bisa 2 kali'
                ]);
            }
        }
        $kontrol = Kontrol::where('mode', 'kontrol')->where('patient_profile_id', $patientId);
        if (!$kontrol) {
            $order = 1;

            $kontrol1 = Kontrol::where('mode', 'resume')->where('patient_profile_id', $patientId)->first();

            if (!$kontrol1) {
                $ambil = 0;
            } else {
                $ambil = 1;
            }
        } else {
            $order = $kontrol->count() + 1;
            $ambil = 1;
            $kontrol1 = $kontrol->orderBy('order', 'desc')->first();
        }

        Kontrol::create([
            'order' => $order,
            'date' => $request->input('date'),
            'tempat_kontrol' => $request->input('tempat_kontrol'),
            'weight' => $request->input('weight'),
            'length' => $request->input('length'),
            'lingkar_kepala' => $request->input('lingkar_kepala'),
            'temperature' => $request->input('temperature'),
            'patient_profile_id' => $patientId,
            'note' => $request->input('note'),
            'nurse_note' => $request->input('nurse_note'),
            'mode' => $request->input('mode'),
        ]);

        $kontrol2 = Kontrol::where('mode', 'kontrol')
            ->where('patient_profile_id', $patientId)
            ->orderBy('order', 'desc')
            ->first();

        if ($ambil == 10) {
            $condition = CountFormula::handle($kontrol1, $kontrol2);
        }

        if ($request->mode == 'resume') {
            $patient = PatientProfile::find($patientId);
            $patient->status = 'home';
            $patient->return_date = now();
            $patient->marked_date = now();
            $patient->save();
        }
        //        $kontrol = new Kontrol;
        //        $kontrol->order = $order;
        //        $kontrol->date = $request->input('date');
        //        $kontrol->tempat_kontrol = $request->input('tempat_kontrol');
        //        $kontrol->weight = $request->input('weight');
        //        $kontrol->length = $request->input('length');
        //        $kontrol->lingkar_kepala = $request->input('lingkar_kepala');
        //        $kontrol->temperature = $request->input('temperature');
        //        $kontrol->patient_profile_id = $patient_id;
        //        $kontrol->note = $request->input('note');
        //        $kontrol->nurse_note = $request->input('nurse_note');
        //        $kontrol->save();

        $kontrolId = Kontrol::orderBy('id', 'desc')->limit(1)->value('id');
        $image = base64_decode($request->input('base64_img'));
        $str = Str::random(10);
        $filename = 'public/kontrol/' . (string) $kontrolId . $request->input('title') . '$' . $str . '.jpg';
        Storage::put($filename, $image);

        Image::create([
            'filename' => $filename,
            'imageable_id' => $kontrolId,
            'imageable_type' => 'App\Models\Kontrol',
        ]);

        return response()->json([
            'message' => 'kontrol is created'
        ]);
    }

    public function edit()
    { }

    public function update(Request $request)
    {
        $kontrol = Kontrol::find($request->id);


        $kontrol->date = $request->input('date');
        $kontrol->tempat_kontrol = $request->input('tempat_kontrol');
        $kontrol->weight = $request->input('weight');
        $kontrol->length = $request->input('length');
        $kontrol->lingkar_kepala = $request->input('lingkar_kepala');
        $kontrol->temperature = $request->input('temperature');
        $kontrol->note = $request->input('note');
        $kontrol->save();
        if ($request->input('base64_img') != "") {
            $image = $kontrol->image;

            Storage::delete($image->filename);
            $newImg = base64_decode($request->input('base64_img'));
            $str = Str::random(10);
            $filename = 'public/kontrol/' . (string) $request->id . $request->input('title') . '$' . $str . '.jpg';
            Storage::put($filename, $newImg);

            $image->filename = $filename;
            $image->save();
        }
        return response()->json([
            'message' => 'kontrol is updated'
        ]);
    }

    public function nurse_note(Request $request)
    {
        $kontrol = Kontrol::find($request->id);
        $kontrol->nurse_note = $request->input('nurse_note');
        $kontrol->save();

        return response()->json([
            'message' => 'kontrol is updated'
        ]);
    }

    public function delete(Request $request)
    {
        $kontrol = Kontrol::find($request->id);
        $image = $kontrol->image;

        Storage::delete($image->filename);
        $image->delete();
        $kontrol->delete();

        return response()->json([
            'message' => 'kontrol is deleted'
        ]);
    }

    public function showResume(Request $request)
    {
        if ($request->id) {
            $pasien = $request->id;
        } else {
            $pasien = $request->user()->userable->id;
        }
        $patient = PatientProfile::find($pasien);
        $resume = $patient->kontrols->where('mode', 'resume')->first();

        return new KontrolRes($resume);
    }
}
