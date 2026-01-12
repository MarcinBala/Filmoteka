<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WantToSee extends Model
{
    protected $fillable = [
        'film_id', 'user_id', 'created_at', 'updated_at'
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
