<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    	'user_id','title','body'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }

    public function categories()
    {
    	return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
