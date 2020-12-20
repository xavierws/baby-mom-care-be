<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required',
           'content' => 'required',
           'base64_img' => 'required',
        ]);

        Materi::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'content_url' => $request->input('content_url', null),
            'video_url' => $request->input('video_url', null),
            'doc_url' => $request->input('doc_url', null),
        ]);

        $materiId = Materi::orderBy('id', 'desc')->pluck('id')->first();

        $image = base64_decode($request->input('base64_img'));
        $filename = 'public/materi/' . (string)$materiId . $request->input('title');
        Storage::put($filename, $image);

        Image::create([
            'filename' => $filename,
            'imageable_id' => $materiId,
            'imageable_type' => 'App\Models\Materi'
        ]);
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function assignMateri()
    {

    }
}
