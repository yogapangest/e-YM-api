<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiDonasi extends Model
{
    use HasFactory;

    protected $fillable =[
        'nominal',
        'deskripsi',
        'file',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id','id');
    }
}