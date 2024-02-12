<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\institude\board_controller;
use App\Http\Controllers\institude\StandardController;
use App\Http\Controllers\institude\SubjectChapterController;
use App\Http\Controllers\institude\SubjectController;
use App\Http\Controllers\institude\SubjectDetailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/verify-otp', [AuthController::class, 'verify_otp'])->name('verify_otp.get');


Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 

Route::group(['middleware' => ['web']], function () {

//Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::get('/auth/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::get('/auth/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('/auth/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
});
Route::post('/institude/get-board', [board_controller::class, 'show'])->name('institude.board.post');
Route::post('/institude/get-standard', [StandardController::class, 'get_standard'])->name('institude.standard.post');
Route::post('/institude/get-subject', [SubjectController::class, 'get_subject'])->name('institude.subject.post');
Route::post('/institude/get-subject-chapter', [SubjectChapterController::class, 'get_subject_chapter'])->name('institude.subject_chapter.post');
Route::post('/institude/get-subject-detail', [SubjectDetailController::class, 'get_subject_detail'])->name('institude.subject_detail.post');
