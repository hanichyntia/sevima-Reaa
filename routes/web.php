<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Siswa;

// 1. Route Root -> Redirect ke Halaman Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Route Login (Di luar middleware guest agar tidak memicu redirect loop)
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');


// 3. Route Register (GUEST)
Route::middleware('guest')->group(function () {
    
    // Admin
    Route::get('/admin/register', function () {
        return view('register.register-admin');
    })->name('admin.register');
    Route::post('/admin/register', [AuthController::class, 'registerAdmin'])->name('admin.register.store');

    // Guru
    Route::get('/guru/register', function () {
        return view('register.register-guru');
    })->name('guru.register');
    Route::post('/guru/register', [AuthController::class, 'registerGuru'])->name('guru.register.store');

    // Siswa
    Route::get('/siswa/register', function () {
        return view('register.register-siswa');
    })->name('siswa.register');
    Route::post('/siswa/register', [AuthController::class, 'registerSiswa'])->name('siswa.register.store');

    // Orang Tua
    Route::get('/orangtua/register', function () {
        $siswas = Siswa::with('user')->get();
        return view('register.register-orang-tua', compact('siswas'));
    })->name('orangtua.register');
    Route::post('/orangtua/register', [AuthController::class, 'registerOrangTua'])->name('orangtua.register.store');
});


// 4. Route Dashboard (AUTH)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/guru/dashboard', function () {
        return view('guru.dashboard');
    })->name('guru.dashboard');

    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');

    Route::get('/orangtua/dashboard', function () {
        return view('orangtua.dashboard');
    })->name('orangtua.dashboard');
});