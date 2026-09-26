<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // 1. Import Contract JWTSubject

class User extends Authenticatable implements JWTSubject // 2. Implementasikan JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mengembalikan ID/Primary Key user untuk dimasukkan ke payload token.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Mengembalikan data kustom tambahan yang ingin dimasukkan ke dalam token.
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role, // Opsional: Memasukkan role ke dalam token JWT
        ];
    }
}