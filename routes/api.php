<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\KontrolController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdviceController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SurveyController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('/test', function () {
//    $data = array();
//    $n = 0;
//    $arr = ['a', 'b', 'c'];
//    foreach ($arr as $a) {
//        $data[$n] = [
//            'id'  => $n,
//            'title' => $a,
//        ];
//        $n++;
//    }
//
//    return response()->json([
//        'data' => $data
//    ]);
//});

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //register the nurse or patient
    Route::post('register', [AuthController::class, 'register']);
    //assign materi for patient
    Route::get('/register/materi', [MateriController::class, 'listMateri']);
    Route::post('/register/materi', [MateriController::class, 'assignMateri']);

    //get the user details
    Route::get('/user', [AuthController::class, 'user']);

    //logout the user
    Route::post('logout', [AuthController::class, 'logout']);

    //kontrol
    //store kontrol
    Route::post('kontrol/store', [KontrolController::class, 'store']);
    //list kontrol
    Route::post('kontrol/index', [KontrolController::class, 'index']);
    //show specific kontrol
    Route::post('kontrol/show', [KontrolController::class, 'show']);
    //update kontrol
    Route::put('kontrol/update', [KontrolController::class, 'update']);
    //delete kontrol
    Route::delete('kontrol/delete', [KontrolController::class, 'delete']);
    //search kontrol

    //materi
    //store materi
    Route::post('materi/store', [MateriController::class, 'store']);
    //list category
    Route::get('materi/category', [MateriController::class, 'listCategory']);
    //list materi
    Route::get('materi/index', [MateriController::class, 'index']);
    //show specific materi
    Route::get('materi/show', [MateriController::class, 'show']);
    //update materi
    Route::put('materi/update', [MateriController::class, 'update']);
    //delete materi
    Route::delete('materi/delete', [MateriController::class, 'delete']);
    //search materi

    //quiz
    //store quiz
    //show specific quiz
    //update quiz
    //delete quiz
    //send the patient's answer

    //forum
    //store forum
    //list topic
    //list forum
    //show specific forum
    //update forum
    //delete forum
    //add comment
    //show all comment related to forum

    //advice - CRUD

    //nurse - dashboard
    Route::post('nurse/index', [NurseController::class, 'listPatient']);
    //admin - dashboard

    //survey - CRUD

    //chat

});
