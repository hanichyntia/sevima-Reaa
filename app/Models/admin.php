<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
   use HasFactory;

   protected $table = 'admins';

    protected $fillable = [
        'user_id', 'created_at', 'updated_at'
    ];
    public $timestamps = false;
}
