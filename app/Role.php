<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role'];

    public function posts()
    {
    	return $this->hasManyThrough(
    		Post::class, //class Post
    		User::class, //class User
    		'role_id',  //foreign dari table users
    		'user_id', //foreign dari table posts
    		'id', //key dari table roles
    		'id' //key dari table users
    	);
    }
}

    /*

	Susunan table
	roles
		id
		role

	users
		id
		role_id
		name 
		email
		password

	posts
		id
		user_id
		title
		body

    */
