<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\SurveyController;

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
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/logout', [AuthController::class, 'logoutUser'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'getUserInfo'])->middleware('auth:sanctum');
Route::middleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class])
    ->post('/auth/validate-token', [AuthController::class, 'validateToken']);

Route::get('/surveys', [SurveyController::class, 'getSurveysForUser'])->middleware('auth:sanctum');