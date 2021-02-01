<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use App\Models\NotificationLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function index()
    {
        return response(Advice::all()->toArray());
    }

    public function show()
    { }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'frequency' => 'required|integer',
            'description' => 'required',
        ]);

        Advice::create([
            'name' => $request->input('name'),
            'frequency' => $request->input('frequency'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'message' => 'advice is created'
        ]);
    }

    public function edit()
    { }

    public function update(Request $request)
    {
        $advice = Advice::find($request->id);
        $advice->name = $request->input('name');
        $advice->frequency = $request->input('frequency');
        $advice->description = $request->input('description');
        $advice->save();
        return response()->json([
            'message' => 'advice is updated',
        ]);
    }

    public function delete(Request $request)
    {
        Advice::find($request->id)->delete();

        return response()->json([
            'message' => 'advice is deleted',
        ]);
    }
    public function send_fcm(Request $request)
    {
        $username = $request->user()->username;
        $user = User::where('username', $username)->first();
        $user->fcm_token = $request->fcm_token;
        $user->save();
        return response()->json([
            'fcm_token' => $user->fcm_token,
        ]);
    }
    public function showNotification(Request $request)
    {
        $now = now();
        $data = array();
        $i = 0;
        $user = $request->user();
        if ($user->user_type == 'patient') {
            $notification = NotificationLog::where('type', 'advice')->orderBy('created_at', 'desc')->get();
            foreach ($notification as $log) {
                $date = Carbon::parse($log->created_at);

                if ($now->diffInDays($date) == 0) {
                    $data[$i] = $log;
                    $i++;
                }
            }
        } else {
            $notification = NotificationLog::where('type', 'kontrol')->orderBy('created_at', 'desc')->get();
            foreach ($notification as $log) {
                if ($log->nurse_id == $user->id) {
                    $data[$i] = $log;
                    $i++;
                }
            }
        }

        return response($data);
    }
}
