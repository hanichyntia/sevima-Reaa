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
            ->cookie('cookies_token', $token, 60 * 24);
    }

    public function registerAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validatedData) {
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role'     => 'admin',
            ]);

            Admin::create([
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran admin berhasil! Silakan login.');
    }

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
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role'     => 'guru',
            ]);

            Guru::create([
                'user_id'        => $user->id,
                'nip'            => $validatedData['nip'],
                'mata_pelajaran' => $validatedData['mata_pelajaran'],
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran guru berhasil! Silakan login.');
    }

    public function registerSiswa(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nis'      => 'required|string|unique:siswas,nis',
        ]);

        DB::transaction(function () use ($validatedData) {
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role'     => 'siswa',
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis'     => $validatedData['nis'],
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran siswa berhasil! Silakan login.');
    }

    public function registerOrangTua(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'siswa_id' => 'required|exists:siswas,id',
        ]);

        DB::transaction(function () use ($validatedData) {
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role'     => 'orang_tua',
            ]);

            OrangTua::create([
                'user_id'  => $user->id,
                'siswa_id' => $validatedData['siswa_id'],
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran orang tua berhasil! Silakan login.');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login')
            ->with('success', 'Berhasil keluar.')
            ->withoutCookie('cookies_token');
    }
}