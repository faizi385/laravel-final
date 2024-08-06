<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'content', 'image', 'tags', 'approved', 'active',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStatusAttribute()
    {
        return $this->active ? 'Active' : 'Inactive';
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    // Define other relationships as needed
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
