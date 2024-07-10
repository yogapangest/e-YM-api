<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'tempat',
        'penerima_manfaat',
        'anggaran',
        'pengeluaran',
        'sisa',
        'file',
        'programs_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'programs_id','id');
    }

    public function distribusibarang()
    {
        return $this->hasMany(DistribusiBarang::class,);
    }
}
