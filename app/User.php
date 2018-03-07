<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function profile()
    {
        return $this->hasOne(Profile::class,'user_id','id');
        //hasOne adalah relasi nya dan parameter nya(class model,foreign_key,primary key)
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'user_id','id');
    }
}
