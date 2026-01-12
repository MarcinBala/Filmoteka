<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'user_type', 'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function newsLikes()
    {
        return $this->hasMany(NewsLike::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function wantToSee()
    {
        return $this->hasMany(WantToSee::class);
    }
}
