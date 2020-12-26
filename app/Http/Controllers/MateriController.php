<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Materi;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Materi as MateriRes;

class MateriController extends Controller
{
    public function listCategory()
    {
        return response(Category::all()->toArray());
    }

    public function index(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $category = Category::find($request->id);

        $data = array();
        $n = 0;
        foreach ($category->materis as $materi) {
            $data[$n] = [
                'id'  => $materi->id,
                'title' => $materi->title,
            ];
            $n++;
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $materi = Materi::find($request->id);
        if (!$materi) {
            throw ValidationException::withMessages([
                'id' => 'id does not exist in database'
            ]);
        }

        return new MateriRes($materi);
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

        return response()->json([
            'message' => 'materi created'
        ]);
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

    public function listMateri()
    {
        $materis = Materi::all()->pluck(['id', 'title']);

        return response($materis->toArray());
    }

    public function assignMateri(Request $request)
    {
        $request->validate([
            'materi' => 'required|array',
            'id' => 'required',
        ]);

        foreach ($request->materi as $materi) {
            Materi::find($materi)->patients()->attach($request->id);
        }

        return response()->json([
            'message' => 'materi are assigned'
        ]);
    }
}
