<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'programs_id',
        'jenisarsips_id',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'programs_id','id');
    }

    public function jenisarsip()
    {
        return $this->belongsTo(JenisArsip::class, 'jenisarsips_id','id');
    }
}
