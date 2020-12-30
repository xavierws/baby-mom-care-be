<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Kontrol;
use App\Models\PatientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Kontrol as KontrolRes;
use Illuminate\Support\Str;

class KontrolController extends Controller
{
    public function index(Request $request)
    {
        $patient = PatientProfile::find($request->id);

        $data = array();
        $n = 0;
        foreach ($patient->kontrols as $kontrol) {
            $data[$n] = [
                'id' => $kontrol->id,
                'title' => $kontrol->title,
            ];
            $n++;
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function search()
    {

    }

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
            'patient_id' => 'required',
            'base64_img' => 'required',
        ]);

        Kontrol::create([
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'tempat_kontrol' => $request->input('tempat_kontrol'),
            'weight' => $request->input('weight'),
            'length' => $request->input('length'),
            'lingkar_kepala' => $request->input('lingkar_kepala'),
            'temperature' => $request->input('temperature'),
            'patient_profile_id' => $request->input('patient_id'),
        ]);

        $kontrolId = Kontrol::orderBy('id', 'desc')->limit(1)->value('id');

        $image = base64_decode($request->input('base64_img'));
        $str = Str::random(10);
        $filename = 'public/kontrol/' . (string)$kontrolId . $request->input('title') . '$' . $str;
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
    {

    }

    public function update(Request $request)
    {
        $kontrol = Kontrol::find($request->id);

        $kontrol->title = $request->input('title');
        $kontrol->date = $request->input('date');
        $kontrol->tempat_kontrol = $request->input('tempat_kontrol');
        $kontrol->weight = $request->input('weight');
        $kontrol->length = $request->input('length');
        $kontrol->lingkar_kepala = $request->input('lingkar_kepala');
        $kontrol->temperature = $request->input('temperature');

        $kontrol->save();

        $image = $kontrol->image;

        Storage::delete($image->filename);
        $newImg = base64_decode($request->input('base64_img'));
        $str = Str::random(10);
        $filename = 'public/kontrol/' . (string)$request->id . $request->input('title') . '$' . $str;
        Storage::put($filename, $newImg);

        $image->filename = $filename;
        $image->save();

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

}
