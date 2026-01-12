<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title', 'content', 'image'
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
        return $this->hasMany(NewsLike::class, 'news_id')->where('like', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(NewsLike::class, 'news_id')->where('like', 0);
    }
}
