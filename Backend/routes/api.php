<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\StatisticsController;

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

/* USER RELATED */
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/logout', [AuthController::class, 'logoutUser'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'getUserInfo'])->middleware('auth:sanctum');
Route::middleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class])
    ->post('/auth/validate-token', [AuthController::class, 'validateToken']);

/* SURVEYORS RELATED */
Route::get('/surveyors', [AuthController::class, 'getAvailableSurveyors'])->middleware('auth:sanctum');

/* SURVEYS RELATED */
Route::get('/surveys', [SurveyController::class, 'getSurveysForUser'])->middleware('auth:sanctum');
Route::get('/survey/{id}', [SurveyController::class, 'getSurveyGivenId'])->middleware('auth:sanctum');
Route::post('/survey/answers', [SurveyController::class, 'postSurveyAnswers'])->middleware('auth:sanctum');
Route::post('/survey', [SurveyController::class, 'postNewSurvey'])->middleware('auth:sanctum');

/* STATISTICS RELATED */
// Route::get('/statistics/surveys', [StatisticsController::class, 'getTotalSurveys'])->middleware('auth:sanctum');
// Route::get('/statistics/answered-questions', [StatisticsController::class, 'getTotalAnsweredQuestions'])->middleware('auth:sanctum');
// Route::get('/statistics/answered-surveys', [StatisticsController::class, 'getTotalAnsweredSurveys'])->middleware('auth:sanctum');