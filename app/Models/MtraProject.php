<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtraProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kontrak',
        'lokasi',
        'latitude',
        'longitude',
        'jenis',
        'foto_path',
        'keterangan',
        'user_id',
        'status',
        'ped_approved',
        'ped_reviewed_at',
        'ped_notes'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'ped_reviewed_at' => 'datetime',
        'ped_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(MtraPhoto::class);
    }
}
