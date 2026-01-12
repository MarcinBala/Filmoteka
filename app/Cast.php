<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    // Cast / Role model

    protected $fillable = [
        'film_id', 'actor_id', 'role', 'order'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function actor()
    {
        return $this->belongsTo(Actor::class);
    }
}
