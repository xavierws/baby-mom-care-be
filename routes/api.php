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
use App\Http\Controllers\PatientController;
use Carbon\Carbon;
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
    $date1 = Carbon::parse('2021-01-09');
    $date2 = Carbon::parse('2021-01-16');
    $divisor = (float)$date2->diffInDays($date1);

    $diffWeight = 594.0 - 500.0;

    if ($diffWeight/$divisor >= 15.0) {
        return 'normal' . ' ' . $divisor . ' ' . $diffWeight;
    } elseif ($diffWeight/$divisor >= 13.5 && $diffWeight/$divisor < 15.0) {
        return 'warning' . ' ' . $divisor . ' ' . $diffWeight;
    } else {
        return 'danger' . ' ' . $divisor . ' ' . $diffWeight;
    }
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

    //update password
    Route::put('password/update', [AuthController::class, 'updatePassword']);

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
    Route::put('kontrol/patient_note', [KontrolController::class, 'patient_note']);
    //delete kontrol
    Route::delete('kontrol/delete', [KontrolController::class, 'delete']);
    //search kontrol
    Route::post('kontrol/search', [KontrolController::class, 'search']);

    //category
    //list category
    Route::get('materi/category', [MateriController::class, 'listCategory']);
    //add new category
    Route::post('materi/category/store', [MateriController::class, 'addCategory']);
    //delete existing category
    Route::delete('materi/category/delete', [MateriController::class, 'destroyCategory']);
    //update category
    Route::put('materi/category/update', [MateriController::class, 'updateCategory']);

    //materi
    //store materi
    Route::post('materi/store', [MateriController::class, 'store']);
    //list materi
    Route::post('materi/index', [MateriController::class, 'index']);
    //show recommended materi for patient
    Route::get('materi/recommended', [MateriController::class, 'showRecommendedMateri']);
    //show specific materi
    Route::post('materi/show', [MateriController::class, 'show']);
    //update materi
    Route::put('materi/update', [MateriController::class, 'update']);
    //delete materi
    Route::delete('materi/delete', [MateriController::class, 'delete']);
    //search materi
    Route::post('materi/search', [MateriController::class, 'search']);

    //quiz
    //store quiz
    Route::post('quiz/store', [QuizController::class, 'store']);
    //show specific quiz
    Route::post('quiz/show', [QuizController::class, 'show']);
    //update quiz
    Route::put('quiz/update', [QuizController::class, 'update']);
    //delete quiz
    Route::delete('quiz/delete', [QuizController::class, 'delete']);
    //send the patient's answer
    Route::post('quiz/answer/store', [QuizController::class, 'storeAnswer']);
    //show patient's answer
    Route::post('quiz/answer/show', [QuizController::class, 'showAnswer']);
    //show quiz status to specific user
    Route::post('quiz/status', [QuizController::class, 'showStatus']);
    //search quiz
    Route::post('quiz/search', [QuizController::class, 'search']);
    //list all quiz
    Route::get('quiz/index', [QuizController::class, 'index']);

    //topic
    //list topic
    Route::get('forum/topic', [ForumController::class, 'listTopic']);
    //add new topic
    Route::post('forum/topic/store', [ForumController::class, 'addTopic']);
    //delete topic
    Route::delete('forum/topic/delete', [ForumController::class, 'destroyTopic']);

    //forum
    //store forum
    Route::post('forum/store', [ForumController::class, 'store']);
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
    Route::delete('nurse/delete', [NurseController::class, 'destroyPatient']);
    Route::put('nurse/data/update', [NurseController::class, 'update']);

    //admin - dashboard
    //list all nurse that has not been approved
    Route::get('admin/list/unapproved-nurse', [AdminController::class, 'listUnApprovedNurse']);
    //approve the nurse
    Route::post('admin/approve-nurse', [AdminController::class, 'approveNurse']);
    //list all approved nurses
    Route::get('admin/list/approved-nurse', [AdminController::class, 'listApprovedNurse']);
    //list all patient that not in relation with the specific nurse
    Route::post('admin/list/patient-nurse', [AdminController::class, 'listPatient']);
    Route::post('admin/list/patient-nurse2', [AdminController::class, 'listPatient2']);
    Route::post('admin/list/patient-nurse3', [AdminController::class, 'listPatient3']);
    //add relation between nurse and patient
    Route::post('admin/add-relation', [AdminController::class, 'addRelation']);
    //remove relation between nurse and patient
    Route::post('admin/remove-relation', [AdminController::class, 'removeRelation']);
    //show specific nurse
    Route::post('admin/nurse/show', [AdminController::class, 'showNurse']);
    Route::delete('admin/nurse/delete', [AdminController::class, 'destroyNurse']);
    //show all patient that belongs to the nurse
    Route::post('admin/nurse/relation', [AdminController::class, 'showNurseRelation']);
    //show pie chart data
    Route::get('admin/survey/chart', [AdminController::class, 'showDataSurvey']);
    //promote nurse to admin
    Route::put('admin/promote', [AdminController::class, 'promoteAdmin']);
    Route::put('admin/demote', [AdminController::class, 'demoteAdmin']);
    //list point for specific patient
    Route::post('admin/quiz/list', [AdminController::class, 'listQuiz']);
    //list survey that has been done by patient
    Route::post('admin/survey/list', [AdminController::class, 'listSurvey']);
    //show survey answer
    Route::post('admin/survey/show', [AdminController::class, 'showSurvey']);
    //show user log
    Route::get('admin/user/log', [AdminController::class, 'showUserLog']);

    //patient
    //list all nurses that related to patient
    Route::get('patient/related-nurse', [PatientController::class, 'listNurse']);
    Route::post('patient/show', [PatientController::class, 'showNurse']);
    //update patient's data
    Route::put('patient/data/update', [PatientController::class, 'update']);

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
    //set chat to read
    Route::post('chat/read-message', [ChatController::class, 'setToRead']);
    Route::get('chat/getunread', [ChatController::class, 'getunread']);
});
