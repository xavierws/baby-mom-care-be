<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function index()
    {
        return response(Advice::all()->toArray());
    }

    public function show()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'frequency' => 'required|integer'
        ]);

        Advice::create([
            'name' => $request->input('name'),
            'frequency' => $request->input('frequency'),
        ]);

        return response()->json([
            'message' => 'advice is created'
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
}
