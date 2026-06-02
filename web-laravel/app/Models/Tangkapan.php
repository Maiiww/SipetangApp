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
        'harga_jual',
        'status',
        'catatan',
        'rejected_by',
        'rejected_at',
        'revision_needed'
    ];

    /**
     * Get the user who submitted this data
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the user who rejected this data
     */
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by', 'id');
    }

    /**
     * Get all notifications for this tangkapan
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'tangkapan_id', 'id');
    }
}
