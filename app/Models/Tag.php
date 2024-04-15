<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'name'
    ];

    public function photo()
    {
        return $this->hasMany(Photo::class);
    }
    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'like', "%$keyword%");
    }
}
