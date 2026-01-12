<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $fillable = [
        'title', 'content', 'image', 'category', 'score'
    ];

    protected $hidden = [
        'user_id', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class)->where('like', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(PostLike::class)->where('like', 0);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
