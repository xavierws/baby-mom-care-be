<?php

namespace App\Http\Controllers;

use App\Models\Chat;
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

        return response($chats);
    }

    public function index()
    {

    }
}
