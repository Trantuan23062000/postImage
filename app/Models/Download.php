<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo_id',
    ];

    // Mối quan hệ giữa model Download và model Photo
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
