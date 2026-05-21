<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tangkapan extends Model
{
    use HasFactory;
    protected $table = 'hasil_tangkap'; 

    protected $fillable = [
        'user_id', 
        'nama_pembeli',
        'nama_nelayan',
        'jenis_ikan',
        'berat',
        'harga_jual'
    ];
}
