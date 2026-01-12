<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = [
        'name', 'photo', 'date_of_birth', 'place_of_birth', 'description'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'date_of_birth'
    ];

    protected $table = "actors";

    public function roles()
    {
        return $this->hasMany(Cast::class, 'actor_id');
    }
}
