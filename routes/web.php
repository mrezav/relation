<?php

use App\User;
use App\Profile;
use App\Post;

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

Route::get('/create_post', function() {
	// $user = User::create([
	// 	'name' => 'Reza',
	// 	'email' => 'reza@vahlevi.com',
	// 	'password' => bcrypt('Password')
	// ]);

	// $user = User::findOrFail(1);

	$user->post()->create([
		'title' => 'Postingan kedua', 
		'body' => 'Ini adalah isi dari postingan kedua reza'
	]);

	return "Berhasil create post";
});

Route::get('read_post', function(){
	$user = User::findOrFail(1);
	$posts = $user->post()->get();
 	
 	foreach($posts as $result){
 		$data[] = [
 			'Nama' => $result->user->name,
 			'title' => $result->title,
 			'body' => $result->body
 		];
 	}

 	return $data;
});

Route::get('/update_post', function(){
	$user = User::findOrFail(1);

	$user->post()->where('id',2)->update(['title' => 'postingan kedua']);

	return 'success';
});

Route::get('/delete_post', function(){
	$user = User::findOrFail(2);

	//Tidak akan bisa menghapus row dengan user_id 2 karena pada objek user hanya ada user id 1
	// $user->post()->whereUserId(2)->delete(); 
	$user->post()->whereUserId(2)->delete();
	// $user->post()->delete();

	return "Success";
});

Route::get('/tes_eloquent', function(){
	$user = User::first();
	$profile = Profile::first();

	return $user->profile;
	// return $profile->user;
});