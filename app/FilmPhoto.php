<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmPhoto extends Model
{
    protected $fillable = [
        'film_id', 'source'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
