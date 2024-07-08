<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    // protected $primaryKey = 'programs_id';

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'file',
    ];
    public function arsips()
    {
        return $this->hasMany(Arsip::class);
    }

    public function Distribusi()
    {
        return $this->hasMany(Distribusi::class);
    }
}
