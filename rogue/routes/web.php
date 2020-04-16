<?php

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



use Illuminate\Support\Facades\Auth;


Auth::routes();



Route::middleware('auth')->group(function () {

    Route::get('/explore', 'FeedController@explore')->name('explore');

    Route::get('/profile', 'ProfilesController@show')->name('profile.show');

    Route::get('/profile/edit', 'ProfilesController@edit')->name('profile.edit');

    Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');

    Route::get('/posts/create', 'PostsController@create')->name('posts.create');

    Route::post('/posts', 'PostsController@store')->name('posts.store');

    Route::post('/comments', 'CommentsController@store')->name('comments.store');

    Route::post('/follow', 'FollowController@follow')->name('user.follow');

    Route::post('/unfollow', 'FollowController@unfollow')->name('user.unfollow');

    Route::post('/vote', 'VotesController@index')->name('user.vote');

});

Route::get('/', 'FeedController@index')->name('home');

Route::get('/profile/{user}', 'ProfilesController@show')->name('profile.show');

Route::get('/posts/{post}', 'PostsController@show')->name('posts.show');

Route::post('/search', 'ProfilesController@search')->name('profile.search');

