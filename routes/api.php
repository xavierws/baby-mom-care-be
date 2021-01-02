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
use App\Models\Quiz;
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

//login
Route::post('login', [AuthController::class, 'login']);

//register nurse using web

//all route that need auth token
Route::middleware('auth:sanctum')->group(function () {
    //register the nurse or patient
    Route::post('register', [AuthController::class, 'register']);
    //assign materi for patient
//    Route::get('/register/materi', [MateriController::class, 'listMateri']);
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
    //show resume pulang
    Route::post('kontrol/resume', [KontrolController::class, 'showResume']);
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
    Route::post('materi/index', [MateriController::class, 'index']);
    //show specific materi
    Route::post('materi/show', [MateriController::class, 'show']);
    //update materi
    Route::put('materi/update', [MateriController::class, 'update']);
    //delete materi
    Route::delete('materi/delete', [MateriController::class, 'delete']);
    //search materi

    //quiz
    //store quiz
    Route::post('quiz/store', [QuizController::class, 'store']);
    //show specific quiz
    Route::post('quiz/show', [QuizController::class, 'show']);
    //update quiz
    //delete quiz
    //send the patient's answer
    Route::post('quiz/answer/store', [QuizController::class, 'storeAnswer']);
    //show patient's answer

    //forum
    //store forum
    Route::post('forum/store', [ForumController::class, 'store']);
    //list topic
    Route::get('forum/topic', [ForumController::class, 'listTopic']);
    //list forum
    Route::post('forum/index', [ForumController::class, 'index']);
    //show specific forum
    Route::post('forum/show', [ForumController::class, 'show']);
    //update forum
    Route::put('forum/update', [ForumController::class, 'update']);
    //delete forum
    Route::delete('forum/delete', [ForumController::class, 'delete']);
    //add comment
    Route::post('forum/comment/store', [ForumController::class, 'storeComment']);

    //advice
    //store advice
    Route::post('advice/store', [AdviceController::class, 'store']);
    //list advice
    Route::get('advice/index', [AdviceController::class, 'index']);
    //update advice
    Route::put('advice/update', [AdviceController::class, 'update']);
    //delete advice
    Route::delete('advice/delete', [AdviceController::class, 'delete']);
    //search advice

    //show notification

    //nurse - dashboard
    Route::post('nurse/index', [NurseController::class, 'listPatient']);
    //admin - dashboard

    //survey - CRUD
    //store survey
    Route::post('survey/store', [SurveyController::class, 'store']);
    //list survey
    Route::get('survey/index', [SurveyController::class, 'index']);
    //show spesific survey
    Route::post('survey/show', [SurveyController::class, 'show']);
    //update survey
    Route::put('survey/update', [SurveyController::class, 'update']);
    //delete survey
    Route::delete('survey/delete', [SurveyController::class, 'delete']);
    //store answer
    Route::post('survey/answer/store', [SurveyController::class, 'storeAnswer']);

    //chat

});
