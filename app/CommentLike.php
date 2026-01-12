<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'comment_id', 'like'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
