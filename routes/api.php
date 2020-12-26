<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    $data = array();
    $n = 0;
    $arr = ['a', 'b', 'c'];
    foreach ($arr as $a) {
        $data[$n] = [
            'id'  => $n,
            'title' => $a,
        ];
        $n++;
    }

    return response()->json([
        'data' => $data
    ]);
});
