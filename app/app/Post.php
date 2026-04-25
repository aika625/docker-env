<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =[
        'user_id',
        'title',
        'body',
        'image',
        'address',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function bookmarks()
    {
        return $this->hasMany('App\Bookmark');
    }

    public function bookmarkedUsers()
    {
        return $this->belongsToMany('App\User', 'bookmarks');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }
}
