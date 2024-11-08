<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//会員登録
Route::prefix('member')->group(function () {
    Route::post('/temporary-registration', [App\Http\Controllers\EmailVerificationController::class, 'temporaryRegistration']);
    Route::post('/official-registration', [App\Http\Controllers\EmailVerificationController::class, 'officialRegistration']);
});

Route::middleware(['cors'])->group(function() {
    Route::post('/login', [App\Http\Controllers\MemberApiController::class, 'login']);
    Route::get('/logout', [App\Http\Controllers\MemberApiController::class, 'logout']);
    Route::post('/me', [App\Http\Controllers\MemberApiController::class, 'member']);

    Route::prefix('object-lineup')->group(function() {
        Route::get('/', [App\Http\Controllers\ObjectController::class, 'objectLineUpData']);
    });
});
