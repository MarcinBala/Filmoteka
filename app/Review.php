<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'score', 'content', 'user_id', 'film_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
