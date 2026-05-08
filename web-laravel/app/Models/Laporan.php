<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'idLaporan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idLaporan',
        'idUser',
        'namaTPI',
        'jenisIkan',
        'beratTotal',
        'tanggalTangkap',
        'status',
        'tanggalInput',
        'tanggalValidasi',
        'validasiOleh',
        'catatan'
    ];

    protected $casts = [
        'tanggalInput' => 'datetime',
        'tanggalTangkap' => 'date',
        'tanggalValidasi' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    /**
     * Scope: Filter laporan pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Filter laporan validated
     */
    public function scopeValidated($query)
    {
        return $query->where('status', 'validated');
    }

    /**
     * Scope: Filter laporan bulan saat ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggalInput', now()->month)
            ->whereYear('tanggalInput', now()->year);
    }
}
