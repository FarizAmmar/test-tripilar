<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\UserController;

// Dashboard
Route::prefix('user')->middleware(['auth', 'role:ADMIN,MANAGER,SUPERVISOR'])->name('user.')->group(function () {
    Route::get('list-user', [UserController::class, 'index'])->name('list');
    Route::get('fetch_user/{id}', [UserController::class, 'fetch_user'])->name('fetch.role');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::get('update/{id}', [UserController::class, 'update'])->name('update');
    Route::get('delete/{id}', [UserController::class, 'destroy'])->name('delete');
});
