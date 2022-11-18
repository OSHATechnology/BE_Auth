<?php

use App\Http\Controllers\API\AuthenticatedController;
use App\Http\Controllers\API\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [AuthenticatedController::class, 'store']);
Route::post('/auth/logout', [AuthenticatedController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthenticatedController::class, 'destroy'])->middleware('auth:sanctum');
