<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'tag_id',
        'title',
        'description',
        'image_url',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('title', 'like', "%$keyword%");
    }
}
