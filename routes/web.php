<?php

use App\User;
use App\Profile;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create_user', function(){
	$user = User::create([
		'name' => 'Indah',
		'email' => 'indah@gmail.com',
		'password' => bcrypt('password')
	]);

	return $user;
});

Route::get('/create_profile', function(){
	$profile = Profile::create([
		'user_id' => 3,
		'phone' => '078789778',
		'address' => 'Jl.batu ampar No.4'
	]); 

	return $profile;
});

Route::get('/create_user_profile', function(){
	$user = User::findOrFail(4);

	// $profile = new Profile([
	// 	'phone' => '0837483332',
	// 	'address' => 'Jl.Kerja bakti No.21'
	// ]);

	// $user->profile()->save($profile);

	$user->profile()->create(['phone' => '0332022', 'address' => 'Jl.Ahmad Sanusi No.43']);

	return $user->profile;
});

Route::get('/read_user/{id}', function($id) {
	$user = User::find($id);

	$data = [
		'nama' => $user->name,
		'phone' => $user->profile->phone,
		'address' => $user->profile->address
	];

	return $data;
});

Route::get('/read_profile', function(){
	$profile = Profile::where('phone','078789778')->first();

	$data = [
		'name' => $profile->user->name,
		'email' => $profile->user->email,
		'phone' => $profile->phone
	];

	return $data;
});

Route::get('/update_profile', function(){
	$user = User::find(3);

	$data = [
		'phone' => '08000088', 
		'address' => 'Jl.cilincing No.22'
	];

	$user->profile()->update($data);

	return $user->profile;
});

Route::get('/delete_profile', function(){
	$user = User::findOrFail(4);

	$user->profile()->delete();

	return $user;
});

Route::get('/tes_eloquent', function(){
	$user = User::first();
	$profile = Profile::first();

	return $user->profile;
	// return $profile->user;
});