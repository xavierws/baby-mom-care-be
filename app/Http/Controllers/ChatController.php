<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Resources\Chat as ChatRes;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;


class ChatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'receiver_id' => 'required',
            'text' => 'required',
        ]);

        Chat::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->input('receiver_id'),
            'text' => $request->input('text'),
        ]);

        return response()->json([
            'message' => 'chat is sent'
        ]);
    }

    public function show(Request $request)
    {
        $chats = Chat::where([
            ['sender_id', $request->user()->id],
            ['receiver_id', $request->receiver_id],
        ])->orWhere([
            ['sender_id', $request->receiver_id],
            ['receiver_id', $request->user()->id],
        ])->orderBy('id', 'asc')->get();

        return ChatRes::collection($chats);
    }

    public function index()
    { }

    public function setToRead(Request $request)
    {
        $receiverId = $request->user()->id;
        $chats = Chat::where([
            ['sender_id', $request->sender_id],
            ['receiver_id', $receiverId]
        ])->get();

        if ($chats) {
            foreach ($chats as $chat) {
                $chat->is_read = true;
                $chat->save();
            }
        }

        $data = request('receiver_id', $receiverId);

        return $this->show($data);
    }
}
