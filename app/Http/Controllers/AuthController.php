<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Simpan token ke dalam cookie
        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ])->cookie('cookies_token', $token, 60 * 24); // Cookie berlaku selama 1 hari
    }

    public function registerAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $result = DB::transaction(function () use ($validatedData) {
            // 1. Simpan ke tabel users
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'admin',
            ]);

            // 2. Simpan ke tabel admins
            $admin = Admin::create([
                'user_id' => $user->id,
            ]);

            // 3. Generate token JWT untuk user yang baru dibuat
            $token = auth()->login($user);

            return [
                'user' => $user,
                'admin' => $admin,
                'token' => $token,
            ];
        });

        // Simpan token ke cookie dan kembalikan respon
        return response()->json([
            'message' => 'Admin registered successfully',
            'token' => $result['token'],
            'data' => [
                'user' => $result['user'],
                'admin' => $result['admin']
            ]
        ], 201)->cookie('cookies_token', $result['token'], 60 * 24);
    }

    public function registerGuru(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|unique:gurus',
            'mata_pelajaran' => 'required|string|max:255',
        ]);

        $result = DB::transaction(function () use ($validatedData) {
            // 1. Simpan ke tabel users
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'guru',
            ]);

            // 2. Simpan ke tabel gurus
            $guru = Guru::create([
                'user_id' => $user->id,
                'nip' => $validatedData['nip'],
                'mata_pelajaran' => $validatedData['mata_pelajaran'],
            ]);

            // 3. Generate token JWT untuk user yang baru dibuat
            $token = auth()->login($user);

            return [
                'user' => $user,
                'guru' => $guru,
                'token' => $token,
            ];
        });

        // Simpan token ke cookie dan kembalikan respon
        return response()->json([
            'message' => 'Guru registered successfully',
            'token' => $result['token'],
            'data' => [
                'user' => $result['user'],
                'guru' => $result['guru']
            ]
        ], 201)->cookie('cookies_token', $result['token'], 60 * 24);
    }
}