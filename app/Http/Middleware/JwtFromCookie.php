<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtFromCookie
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Ambil token dari cookie bernama 'cookies_token'
        if ($token = $request->cookie('cookies_token')) {
            // Masukkan token ke header request secara diam-diam
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        try {
            // 2. Validasi dan autentikasi user berdasarkan token tersebut
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            // Jika token tidak ada, kedaluwarsa, atau tidak valid, tendang ke halaman login
            return redirect()->route('login')->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}
