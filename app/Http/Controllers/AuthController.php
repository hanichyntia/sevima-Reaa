<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\OrangTua;

class AuthController extends Controller
{
    // 1. LOGIN: Token HANYA didapatkan di sini
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!$token = auth()->attempt($credentials)) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        // Redirect sesuai role dan set cookie token
        $user = auth()->user();
        $redirectRoute = match ($user->role) {
            'admin'     => 'admin.dashboard',
            'guru'      => 'guru.dashboard',
            'siswa'     => 'siswa.dashboard',
            'orang_tua' => 'orangtua.dashboard',
            default     => 'login',
        };

        return redirect()->route($redirectRoute)
            ->with('success', 'Login berhasil!')
            ->cookie('cookies_token', $token, 60 * 24); // Token berlaku 1 hari
    }

    // 2. REGISTER ADMIN (Tanpa Token)
    public function registerAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validatedData) {
            // Simpan ke tabel users
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role'     => 'admin',
            ]);

            // Simpan ke tabel admins
            Admin::create([
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran admin berhasil! Silakan login.');
    }

    // 3. REGISTER GURU (Tanpa Token)
    public function registerGuru(Request $request)
    {
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:8|confirmed',
            'nip'            => 'required|string|unique:gurus,nip',
            'mata_pelajaran' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData) {
            // Simpan ke tabel users
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role'     => 'guru',
            ]);

            // Simpan ke tabel gurus
            Guru::create([
                'user_id'        => $user->id,
                'nip'            => $validatedData['nip'],
                'mata_pelajaran' => $validatedData['mata_pelajaran'],
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran guru berhasil! Silakan login.');
    }

    // 4. REGISTER SISWA (Tanpa Token)
    public function registerSiswa(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nis'      => 'required|string|unique:siswas,nis',
        ]);

        DB::transaction(function () use ($validatedData) {
            // Simpan ke tabel users
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role'     => 'siswa',
            ]);

            // Simpan ke tabel siswas
            Siswa::create([
                'user_id' => $user->id,
                'nis'     => $validatedData['nis'],
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran siswa berhasil! Silakan login.');
    }

    // 5. REGISTER ORANG TUA (Tanpa Token)
    public function registerOrangTua(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'siswa_id' => 'required|exists:siswas,id',
        ]);

        DB::transaction(function () use ($validatedData) {
            // Simpan ke tabel users
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role'     => 'orang_tua',
            ]);

            // Simpan ke tabel orang_tuas
            OrangTua::create([
                'user_id'  => $user->id,
                'siswa_id' => $validatedData['siswa_id'],
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran orang tua berhasil! Silakan login.');
    }

    // 6. LOGOUT
    public function logout()
    {
        auth()->logout();

        return redirect()->route('login')
            ->with('success', 'Berhasil keluar.')
            ->withoutCookie('cookies_token'); // Menghapus cookie token
    }
}