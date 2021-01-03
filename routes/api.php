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

Route::get('/test', function () {
    $now = now();
    $date = \Carbon\Carbon::parse(\App\Models\Role::find(10)->created_at);
    $diff = $now->diffInDays($date);
    $diff2 = $date->diffInDays($now);
    return response()->json([
        'now' => $now,
        'date' => $date,
        'diff'  => $diff,
        'diff2' => $diff2,
        'dayOfYear' => $date->dayOfYear,
        'date2' => $date->format('Y-m-d H:i:s')
    ]);
});

//login
Route::post('login', [AuthController::class, 'login']);

//all route that need auth token
Route::middleware('auth:sanctum')->group(function () {
    //register the nurse or patient
    Route::post('register', [AuthController::class, 'register']);
    //assign materi for patient
    Route::get('/register/list', [MateriController::class, 'listMateri']);
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
    //add nurse note
    Route::put('kontrol/nurse_note', [KontrolController::class, 'nurse_note']);
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
    Route::post('quiz/answer/show', [QuizController::class, 'showAnswer']);
    //show quiz status to specific user
    Route::post('quiz/status', [QuizController::class, 'showStatus']);

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
    //send fcm_token
    Route::post('advice/send_fcm', [AdviceController::class, 'send_fcm']);
    //show notification
    Route::get('advice/notification', [AdviceController::class, 'showNotification']);

    //nurse - dashboard
    Route::post('nurse/index', [NurseController::class, 'listPatient']);
    Route::post('nurse/show', [NurseController::class, 'showPatient']);

    //admin - dashboard
    //list all nurse that has not been approved
    Route::get('admin/list/unapproved-nurse', [AdminController::class, 'listUnApprovedNurse']);
    //approve the nurse
    Route::post('admin/approve-nurse', [AdminController::class, 'approveNurse']);
    //list all approved nurses
    Route::get('admin/list/approved-nurse', [AdminController::class, 'listApprovedNurse']);
    //list all patient that not in relation with the specific nurse
    Route::get('admin/list/patient-nurse', [AdminController::class, 'listPatient']);
    //add relation between nurse and patient
    Route::post('admin/add-relation', [AdminController::class, 'addRelation']);

    //survey
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
    //send chat
    Route::post('chat/send-message', [ChatController::class, 'store']);
    //show all chat
    Route::post('chat/show-message', [ChatController::class, 'show']);

});
