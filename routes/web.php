<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Route::get('/login', [App\Http\Controllers\HomeController::class, 'index'])->name('login');
    Route::post('/registration', [App\Http\Controllers\HomeController::class, "home"])->name('registration');

    Route::prefix("member")->group(function() {
        Route::get('/create', [App\Http\Controllers\HomeController::class, 'create'])->name('member.create');
        Route::get('/{id}/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('member.edit');
        Route::post('/save', [App\Http\Controllers\HomeController::class, 'save'])->name('member.save');
        Route::get('/{id}/delete', [App\Http\Controllers\HomeController::class, 'delete'])->name('member.delete');
    });

    Route::prefix("object-lineup")->group(function() {
        Route::get('/', [App\Http\Controllers\ObjectController::class, 'index'])->name('object-lineup');
        Route::get('/create', [App\Http\Controllers\ObjectController::class, 'create'])->name('object-lineup.create');
        Route::get('/{id}/edit', [App\Http\Controllers\ObjectController::class, 'edit'])->name('object-lineup.edit');
        Route::post('/save', [App\Http\Controllers\ObjectController::class, 'save'])->name('object-lineup.save');
        Route::get('/{id}/delete', [App\Http\Controllers\ObjectController::class, 'delete'])->name('object-lineup.delete');
    });
});

