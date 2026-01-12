<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'film_id', 'name'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
