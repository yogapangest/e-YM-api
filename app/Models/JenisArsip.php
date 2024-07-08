<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisArsip extends Model
{
    use HasFactory;

    // protected $primaryKey = 'jenisarsips_id';

    protected $fillable = [
        'nama_arsip',
        'deskripsi',
    ];

    public function arsips()
    {
        return $this->hasMany(Arsip::class);
    }
}
