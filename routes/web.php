<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('register-nurse', [AuthController::class, 'showRegisterPage']);
Route::post('register-nurse', [AuthController::class, 'registerNurse'])->name('register');

Auth::routes(['register' => false]);

// Route::get('login', [AuthWebController::class, ''])->name('login');
// Route::get('logout', [AuthWebController::class, ''])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/kuis', [QuizController::class, 'dumpMateri'])->name('kuis.materi');

Route::get('/kuis/{id}', [QuizController::class, 'createNew'])->name('kuis.add');

Route::get('/kuis/{id}/add', [QuizController::class, 'savePage'])->name('kuis.page');
Route::post('/kuis/{id}/add', [QuizController::class, 'saveKuis'])->name('kuis.save');
Route::get('/kuis/{id}/edit', [QuizController::class, 'editPage'])->name('kuis.edit');
Route::post('/kuis/{id}/edit', [QuizController::class, 'editKuis'])->name('kuis.update');


