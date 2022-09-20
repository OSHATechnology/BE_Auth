<?php

use App\Http\Controllers\AdminAccessController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('admin_access/register', [AuthController::class, 'register']);
Route::post('admin_access/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('admin_access', [AdminAccessController::class, 'index']);
    Route::post('admin_access/store', [AdminAccessController::class, 'store']);
    Route::get('admin_access/show/{id}', [AdminAccessController::class, 'show']);
    Route::put('admin_access/update/{id}', [AdminAccessController::class, 'update']);
    Route::delete('admin_access/destroy/{id}', [AdminAccessController::class, 'destroy']);
    Route::post('admin_access/logout', [AuthController::class, 'logout']);
});
