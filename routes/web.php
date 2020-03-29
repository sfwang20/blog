<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

// CRUD
// 3 routing: create/edit/list

Route::middleware(['auth'])->group(function()
{
  Route::get('/posts/admin', 'PostController@admin');
  Route::get('/posts/create', 'PostController@create');
  Route::get('/posts/{post}/edit', 'PostController@edit');

  Route::post('/posts', 'PostController@store');
  Route::get('/posts/show/{post}', 'PostController@showByAdmin');
  Route::put('/posts/{post}', 'PostController@update');
  Route::delete('/posts/{post}', 'PostController@destroy');

  Route::resource('categories', 'CategoryController')->except(['show']);
  Route::resource('tags', 'TagController')->only(['index', 'destroy']);
});

Route::resource('comments', 'CommentController')->only(['store', 'update', 'destroy']);

Route::get('/posts', 'PostController@index');
Route::get('/posts/category/{category}', 'PostController@indexWithCategory');
Route::get('/posts/tag/{tag}', 'PostController@indexWithTag');
Route::get('/posts/{post}', 'PostController@show');


// Route::get('/posts', function () {
//     $posts = [1, 2, 3, 4, 5];
//     return view('posts.list', ['posts'=>$posts]);
// });

Route::get('/posts/{id}', function ($id) {
    return view('posts.show');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
