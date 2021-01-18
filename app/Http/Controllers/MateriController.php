<?php

namespace App\Http\Controllers;

use App\Actions\StoreImage;
use App\Models\Category;
use App\Models\Image;
use App\Models\Materi;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Materi as MateriRes;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    public function addCategory(Request $request)
    {
        Category::create([
            'name' => $request->input('name')
        ]);

        if ($request->base64_image) {
            $categoryId = Category::orderBy('id', 'desc')->limit(1)->value('id');
            $image = $request->input('base64_img');

            StoreImage::handle(
                $categoryId,
                $image,
                'public/category/',
                $request->input('name'),
                'App\Models\Category'
            );
        }

        return response()->json([
            'message' => 'category is added'
        ]);
    }

    public function destroyCategory(Request $request)
    {
        $category = Category::find($request->input('id'));
        $image = $category->image;

        Storage::delete($image->filename);
        $image->delete();
        $category->delete();

        return response()->json([
            'message' => 'category is deleted'
        ]);
    }

    public function listCategory()
    {
        $categories = Category::all();

        $i = 0;
        $data = array();
        foreach ($categories as $category) {
            if (!$category->image->filename) {
                $image = null;
            } else {
                $image = asset($category->image->filename);
            }

            $data[$i] = [
                'id' => $category->id,
                'image' => $image,
                'name' => $category->name,
            ];
            $i++;
        }

        return response($data);
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
                'quiz' => $materi->related_quiz,
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
            'category_id' => 'required',
        ]);

        Materi::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'content_url' => $request->input('content_url', null),
            'video_url' => $request->input('video_url', null),
            'doc_url' => $request->input('doc_url', null),
            'category_id' => Category::where('id', $request->category_id)->pluck('id')->first(),
            'forum_id' => $request->input('forum_id', null),
        ]);

        $materiId = Materi::orderBy('id', 'desc')->pluck('id')->first();

        $image = base64_decode($request->input('base64_img'));
        $str = Str::random(10);
        $filename = 'public/materi/' . (string)$materiId . $request->input('title') . '$' . $str . '.jpg';
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

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $materi = Materi::find($request->id);

        $materi->title = $request->input('title');
        $materi->content = $request->input('content');
        $materi->content_url = $request->input('content_url');
        $materi->video_url = $request->input('video_url');
        $materi->doc_url = $request->input('doc_url');
//        $materi->forum_id = $request->input('forum_id');
        $materi->save();

        $image = $materi->image;
        Storage::delete($image->filename);
        $newImg = base64_decode($request->input('base64_img'));
        $str = Str::random(10);
        $filename = 'public/materi/' . (string)$materi->id . $request->input('title') . '$' . $str . '.jpg';
        Storage::put($filename, $newImg);

        $image->filename = $filename;
        $image->save();

        return response()->json([
            'message' => 'materi is updated'
        ]);
    }

    public function delete(Request $request)
    {
        $materi = Materi::find($request->id);
        $image = $materi->image;

        Storage::delete($image->filename);
        $image->delete();
        $materi->delete();

        return response()->json([
            'message' => 'materi is deleted'
        ]);
    }

    public function listMateri()
    {
        $materi = Materi::all();

        $data = array();
        for($i=0;$i<count($materi);$i++) {
            $data[$i] = [
                'id'  => $materi[$i]->id,
                'name' => $materi[$i]->title
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function assignMateri(Request $request)
    {

        foreach ($request->materis as $materi) {
            Materi::find($materi)->patients()->attach($request->id);
        }

        return response()->json([
            'message' => 'materi are assigned'
        ]);
    }

    public function showRecommendedMateri(Request $request)
    {
        $patient = $request->user()->userable;

        return response()->json([
            'materi' => $patient->materis,
        ]);
    }
}
