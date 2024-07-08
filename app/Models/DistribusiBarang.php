<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribusiBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribusis_id',
        'nama_barang',
        'volume',
        'satuan',
        'harga_satuan',
        'jumlah',
    ];

    public function distribusi()
    {
        return $this->belongsTo(Distribusi::class, 'distribusis_id','id');
    }
}
