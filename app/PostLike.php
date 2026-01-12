<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'post_id', 'like'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
