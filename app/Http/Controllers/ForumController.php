<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forum;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\Forum as ForumRes;

class ForumController extends Controller
{
    public function listTopic()
    {
        return response(Topic::all()->toArray());
    }

    public function index(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $topic = Topic::find($request->id);

        $data = array();
        $n = 0;
        foreach ($topic->forum as $forum) {
            $data[$n] = [
                'id'  => $forum->id,
                'title' => $forum->title,
                'question' => $forum->question,
                'user' => $forum->user->name,
            ];
            $n++;
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function show(Request $request)
    {
        return new ForumRes(Forum::find($request->id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'question' => 'required',
            'topic' => 'required',
        ]);

        $user = $request->user();

        Forum::create([
            'title' => $request->input('title'),
            'question' => $request->input('question'),
            'user_id' => $user->id,
            'topic_id' => Topic::where('name', $request->topic)->pluck('id')->first(),
        ]);

        return response()->json([
            'message' => 'forum created'
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

    public function storeComment(Request $request)
    {
        $request->validate([
            'text' => 'required|max:1000',
            'forum_id' => 'required'
        ]);

        $user = $request->user();

        Comment::create([
            'text' => $request->input('text'),
            'forum_id' => $request->input('forum_id'),
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'comment created'
        ]);
    }
}