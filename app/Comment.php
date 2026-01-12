<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'post_id', 'reply_to_id', 'user_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class)->where('like', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(CommentLike::class)->where('like', 0);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_to_id')->orderBy('created_at');
    }

    public function getScoreAttribute()
    {
        $id = $this->id;
        $likes = CommentLike::where('comment_id', $id)->where('like', 1)->count();
        $dislikes = CommentLike::where('comment_id', $id)->where('like', 0)->count();
        return $likes - $dislikes;
    }
}
