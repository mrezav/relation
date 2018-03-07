<?php

use App\User;
use App\Profile;
use App\Post;
use App\Category;
use App\Role;

Route::get('/', function () {
    return view('welcome');
});

//Membuat user
Route::get('/create_user', function(){
	$user = User::create([
		'name' => 'Indah',
		'email' => 'indah@gmail.com',
		'password' => bcrypt('password')
	]);

	return $user;
});

//membuat profile user
Route::get('/create_profile', function(){
	$profile = Profile::create([
		'user_id' => 2,
		'phone' => '078789778',
		'address' => 'Jl.batu ampar No.4'
	]); 

	return $profile;
});

//membuat profile melalui method profile yang ada pada objek user.
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

//Menampilkan data user dan profile melalui method profile pada objek user berdasarkan id.
Route::get('/read_user/{id}', function($id) {
	$user = User::find($id);

	$data = [
		'nama' => $user->name,
		'phone' => $user->profile->phone,
		'address' => $user->profile->address
	];

	return $data;
});

//menampilan profile dan user melalui method user yang ada pada objek profile
Route::get('/read_profile', function(){
	$profile = Profile::where('phone','078789778')->first();

	$data = [
		'name' => $profile->user->name,
		'email' => $profile->user->email,
		'phone' => $profile->phone
	];

	return $data;
});

//update data profile
Route::get('/update_profile', function(){
	$user = User::find(3);

	$data = [
		'phone' => '08000088', 
		'address' => 'Jl.cilincing No.22'
	];

	$user->profile()->update($data);

	return $user->profile;
});

//menghapus data profile
Route::get('/delete_profile', function(){
	$user = User::findOrFail(4);

	$user->profile()->delete();

	return $user;
});

//membuat data post dengan melalui method posts yang ada pada objek user yang memiliki id 1
Route::get('/create_post', function() {
	$user = User::findOrFail(2);

	$user->posts()->create([
		'title' => 'Title post kedua(member)', 
		'body' => 'Hello ! ini adalah isi post kedua(member)'
	]);

	return "Berhasil create post";
});

Route::get('read_post', function(){
	$user = User::findOrFail(1);
	$posts = $user->posts()->get();
 	
 	foreach($posts as $result){
 		$data[] = [
 			'Nama' => $result->user->name,
 			'title' => $result->title,
 			'body' => $result->body
 		];
 	}

 	return $data;
});

//mengupdate data post melalui method posts yang ada pada objek user
Route::get('/update_post', function(){
	$user = User::findOrFail(1);

	$user->posts()->where('id',2)->update(['title' => 'postingan kedua']);

	return 'success';
});

//menghapus data post melalui method posts yang ada pada objek user
Route::get('/delete_post', function(){
	$user = User::findOrFail(2);

	//Tidak akan bisa menghapus row dengan user_id 2 karena pada objek user hanya ada user id 1
	// $user->post()->whereUserId(2)->delete(); 
	
	$user->posts()->whereUserId(2)->delete();
	// $user->post()->delete();

	return "Success";
});

//melihat relasi 
Route::get('/tes_eloquent', function(){
	$user = User::first();
	$profile = Profile::first();

	return $user->profile;
	// return $profile->user;
});

//membuat category melalui method categories yang ada di objek post
Route::get('create_category', function(){
	$post = Post::findOrFail(1);

	$post->categories()->create([
		'slug' => str_slug('Security','-'),
		'category' => 'Security'
	]);

	return "Success";
});

//menampilkan post dan kategory
Route::get('read_post_category', function(){
	$posts = Post::all();
	foreach($posts as $post)
	{
		$categories = $post->categories;

		echo "<h3> Title : ".$post->title."</h3>";
		foreach($categories as $category)
		{
			echo "<dd>".$category->slug.'</dd>';
		}
	}
	
	echo "<br><br>";

	$categories = Category::all();
	foreach($categories as $category)
	{	
		$posts = $category->posts;

		echo "<h3> Kategori : ".$category->slug."</h3>";
		foreach ($posts as $post) {
			echo "<dd>".$post->title."</dd>";
		}
	}

});

//membuat relasi data post yang id nya 2 dengan categori yang id nya 1 dan 3 sekaligus
Route::get('attach', function(){
	$post = Post::findOrFail(2);

	$post->categories()->attach([1,2,3]);

	return "Success";
});

//menghapus relasi data post yang id nya 2 dengan categori yang id nya 1 dan 3 sekaligus
Route::get('detach', function(){
	$post = Post::findOrFail(2);

	$post->categories()->detach([1,3]);

	return "Success";
});

//update data post yang id nya 2 dengan data category id 2 dan tiga menggunakan chain method sync 
Route::get('sync', function(){
	$post = Post::findOrFail(2);

	$post->categories()->sync([2,3]);

	return redirect('read_post_category');
});

Route::get('/role/posts', function(){
	$role = Role::findOrFail(2);
	return $role->posts;
});

//membuat row di semua table sekaligus menggunakan chain method dari objek user
Route::get('create_all', function(){
	$user = User::create([
		'name' => 'Jojo',
		'email' => 'jojo@mail.com',
		'password' => bcrypt('pass')
	]);

	$user->profile()->create([
		'phone' => '0839493434',
		'address' => 'Jl.Koco No.22'
	]);

	$user->posts()->create([
		'title' => 'Mengamankan password',
		'body' => 'Salah satu cara mengamankan password adalah dengan bcrypt'
	])->categories()->create([
		'slug' => str_slug('New Category','-'),
		'category' => 'Ini adalah kategori yang baru'
	]);

	return "Success";
});