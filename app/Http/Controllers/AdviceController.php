<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use App\Models\NotificationLog;
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

    public function showNotification()
    {
        $now = now();
        $data = array();
        $i = 0;
        foreach (NotificationLog::all() as $log) {
            $date = $log->created_at;

            if ($now->diffInDays($date) == 0) {
                $data[$i] = $log->advice;
                $i++;
            }
        }

        return response($data);
    }
}
