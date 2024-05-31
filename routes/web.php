<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use Illuminate\Support\Facades\Route;


// Prefix Authentication
Route::prefix('/')->middleware('guest')->name('auth.')->group(function () {
    Route::get('/', [AuthenticatedController::class, 'login_view'])->name('login');
    Route::post('/login/store', [AuthenticatedController::class, 'login_store'])->name('login.store');

    Route::get('/register', [AuthenticatedController::class, 'register_view'])->name('register');
    Route::post('/register/store', [AuthenticatedController::class, 'register_store'])->name('register.store');
});

Route::get('/logout', [AuthenticatedController::class, 'logout'])->name('logout');



// Menambahkan method auth
include __DIR__ . "/auth.php";
