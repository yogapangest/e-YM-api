<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontenProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kontenprogram',
        'foto'
    ];
}
