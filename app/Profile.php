<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	public $primaryKey = 'user_id';
    protected $fillable = [
    	'user_id', 'phone', 'address'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
