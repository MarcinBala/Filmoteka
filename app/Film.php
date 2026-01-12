<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'title', 'original_title', 'release', 'image', 'video', 'description', 'length'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'release'
    ];

    public function genres()
    {
        return $this->hasMany(Genre::class);
    }

    public function directors()
    {
        return $this->hasMany(Director::class);
    }

    public function writers()
    {
        return $this->hasMany(Writer::class);
    }

    public function cast()
    {
        return $this->hasMany(Cast::class)->orderBy('order');
    }

    public function production()
    {
        return $this->hasMany(Production::class);
    }

    public function photos()
    {
        return $this->hasMany(FilmPhoto::class);
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
