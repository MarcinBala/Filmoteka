<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsLike extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'news_id', 'like'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
