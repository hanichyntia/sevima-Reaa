<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Sesuaikan dengan nama Controller Anda

// Route untuk menampilkan halaman form
Route::get('/admin/register', function () {
    return view('register.register-admin');
})->name('admin.register');

// Route untuk proses submit
Route::post('/admin/register', [AuthController::class, 'registerAdmin'])->name('admin.register.store');