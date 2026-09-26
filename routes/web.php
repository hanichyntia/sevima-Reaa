<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Siswa;

// 1. Halaman Utama -> Redirect ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Halaman Login
Route::get('/login', function () {
    return view('login'); // Pastikan file resources/views/login.blade.php ada
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// 3. Register Orang Tua
Route::get('/orangtua/register', function () {
    $siswas = Siswa::with('user')->get();
    return view('register.register-orang-tua', compact('siswas'));
})->name('orangtua.register');

Route::post('/orangtua/register', [AuthController::class, 'registerOrangTua'])->name('orangtua.register.store');

// 4. Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 5. Dashboard
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
Route::get('/guru/dashboard', function () { return view('guru.dashboard'); })->name('guru.dashboard');
Route::get('/siswa/dashboard', function () { return view('siswa.dashboard'); })->name('siswa.dashboard');
Route::get('/orangtua/dashboard', function () { return view('orangtua.dashboard'); })->name('orangtua.dashboard');