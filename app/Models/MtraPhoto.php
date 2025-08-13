<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtraPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'mtra_project_id',
        'path',
        'caption'
    ];

    public function mtraProject()
    {
        return $this->belongsTo(MtraProject::class);
    }
}
