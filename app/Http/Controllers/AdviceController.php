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

    public function list()
    {
        $advice = Advice::all();

        $data = array();
        for ($i = 0; $i < count($advice); $i++) {
            $data[$i] = [
                'id'  => $advice[$i]->id,
                'name' => $advice[$i]->name
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function listForPatient(Request $request)
    {
        $resume = $request->user()->userable->kontrols()->where('mode', 'resume')->get();
        $advice = '';
        foreach ($resume as $r) {
            $advice = $r->advices;
        }

        return response()->json([
            'data' => $advice
        ]);
    }

    public function show()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Advice::create([
            'name' => $request->input('name'),
            'frequency' => '',
            'description' => ''
        ]);

        return response()->json([
            'message' => 'advice is created'
        ]);
    }

    public function edit()
    {
    }

    public function update(Request $request)
    {
        $advice = Advice::find($request->id);
        $advice->name = $request->input('name');
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
        if ($user->role_id == 10) {
            $notification = NotificationLog::where('type', 'advice')->where('nurse_id', $user->userable->id)->orderBy('created_at', 'desc')->get();
            foreach ($notification as $log) {
                $date = Carbon::parse($log->created_at);
                if ($now->diffInDays($date) == 0) {
                    $data[$i] = $log;
                    $i++;
                }
            }

            $notification_survey = NotificationLog::where('type', 'survey')->where('nurse_id', $user->userable->id)->orderBy('created_at', 'desc')->get();
            foreach ($notification_survey as $log) {
                $data[$i] = $log;
                $i++;
            }
        } else {
            $data1 = NotificationLog::where('type', 'kontrol')->where('nurse_id', $user->userable->id)->orderBy('created_at', 'desc');
            $data1->update(['isRead' => 1]);
            $data = $data1->get();
        }

        return response($data);
    }

    public function getUnreadNotif(Request $request)
    {
        $user = $request->user();
        $data = NotificationLog::where('type', 'kontrol')
            ->where('nurse_id', $user->userable->id)
            ->where('isRead', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => count($data),
        ]);
    }
}
