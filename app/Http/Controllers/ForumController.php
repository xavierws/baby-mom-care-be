<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\Forum as ForumRes;
use Illuminate\Database\Eloquent\Builder;

class ForumController extends Controller
{
    public function listTopic()
    {
        $topics = Topic::all();
        $n = 0;
        foreach ($topics as $topic) {
            $data[$n] = [
                'id'  => $topic->id,
                'name' => $topic->name,
            ];
            $n++;
        }
        return response()->json([
            'data' => $data
        ]);
    }

    public function addTopic(Request $request)
    {
        Topic::create([
            'name' =>  $request->input('name'),
        ]);

        return response()->json([
            'message' => 'topic is created'
        ]);
    }

    public function destroyTopic(Request $request)
    {
        Topic::find($request->id)->delete();

        return response()->json([
            'message' => 'topic is deleted'
        ]);
    }

    public function listForum()
    {
        $data = array();
        $i = 0;
        foreach (Forum::all() as $forum) {
            $data[$i] = [
                'id' => $forum->id,
                'name' => $forum->title,
            ];
            $i++;
        }

        return response($data);
    }

    public function index(Request $request)
    {
        $request->validate([
            'topic_id' => 'required',
        ]);

        $user = $request->user();
        $topic = Topic::find($request->topic_id);

        if ($user->role_id == 22) {
            $forums = $topic->forums;
        } else {
            $forums = $topic->forums()
            ->whereHas('user', function (Builder $query) use ($user) {
                $query->whereHas('userable', function (Builder $query) use ($user) {
                    $query->where('hospital_id', $user->userable->hospital_id);
                });
            })
            ->get();
        }

        $data = array();
        $n = 0;
        foreach ($forums as $forum) {
            $data[$n] = [
                'id'  => $forum->id,
                'title' => $forum->title,
                'question' => $forum->question,
                'user' => $forum->user->profile_name,
                'total_comment' => $forum->comments()->count(),
//                'category' => $forum->category->name,
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
            'topic_id' => 'required',
        ]);

        $user = $request->user();

        Forum::create([
            'title' => $request->input('title'),
            'question' => $request->input('question'),
            'user_id' => $user->id,
            'topic_id' => $request->input('topic_id'),
        ]);

        return response()->json([
            'message' => 'forum created'
        ]);
    }

    public function edit()
    { }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $forum = Forum::find($request->id);
        $forum->title = $request->input('title');
        $forum->question = $request->input('question');
        $forum->save();

        return response()->json([
            'message' => 'forum is updated'
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $forum = Forum::find($request->id);
        foreach ($forum->comments as $comment) {
            $comment->delete();
        }
        $forum->delete();

        return response()->json([
            'message' => 'forum is deleted',
        ]);
    }

    public function search(Request $request)
    {
        return ForumRes::collection(
            Forum::where('title', 'LIKE', '%' . $request->keyword . '%')
            ->orWhere('question', 'LIKE', '%' . $request->keyword . '%')
            ->get()
        );
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
