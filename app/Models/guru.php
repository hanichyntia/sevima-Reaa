<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class guru extends Model
{
   use HasFactory;
   protected $table = 'gurus';
   protected $fillable = [

        'user_id', 'nip', 'mata_pelajaran', 'created_at', 'updated_at'
    ];
}
