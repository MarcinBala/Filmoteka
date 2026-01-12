<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = [
        'film_id', 'name'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
