<?php

use Illuminate\Support\Facades\Route;

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

/*
Route::get('/', function () {
    return view('home');
});*/

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home.index');

Route::post('/user/{user}/update', 'UserController@update')->name('user.update');
Route::get('/user/{user}/edit_profile', 'UserController@edit')->name('user.edit');
Route::get('/user/{user}/favourite_films', 'UserController@favourites')->name('user.favourites');
Route::get('/user/{user}/want_to_see', 'UserController@wantToSee')->name('user.wantToSee');
Route::get('/user/{user}/posts', 'UserController@posts')->name('user.posts');
Route::get('/user/{user}', 'UserController@index')->name('user.show');

Route::get('/news', 'NewsController@index')->name('news.index');
Route::get('/news/{news}', 'NewsController@show')->name('news.show');
Route::post('/news/like', 'NewsController@like')->name('news.like');

Route::get('/film/{film}/review', 'ReviewController@create')->name('review.create');
Route::post('/review', 'ReviewController@store')->name('review.store');
Route::delete('/film/{film}/review/destroy', 'ReviewController@destroy')->name('review.destroy');

Route::get('/discover', 'DiscoverController@index')->name('discover.index');
Route::post('/discover/result', 'DiscoverController@result')->name('discover.result');
Route::get('/discover/autocomplete', 'DiscoverController@autocomplete')->name('discover.autocomplete');

Route::get('/releases/{month}', 'ReleaseController@index')->name('releases.index');

Route::get('/forum', 'ForumController@index')->name('forum.index');
Route::get('/forum/hot', 'ForumController@hot')->name('forum.hot.show');
Route::get('/forum/new', 'ForumController@new')->name('forum.news.show');
Route::get('/forum/best', 'ForumController@best')->name('forum.best.show');

Route::get('/p/create', 'PostController@create')->name('post.create');
Route::get('/p/{post}/edit', 'PostController@edit')->name('post.edit');
Route::post('/p/{post}/update', 'PostController@update')->name('post.update');
Route::delete('/p/{post}', 'PostController@destroy')->name('post.destroy');
Route::get('/p/{post}', 'PostController@show')->name('post.show');
Route::post('/p', 'PostController@store')->name('post.store');
Route::post('/p/like', 'PostController@like')->name('post.like');

Route::get('/comment/view', 'CommentController@view')->name('comment.view');
Route::post('/comment/like', 'CommentController@like')->name('comment.like');
Route::post('/comment', 'CommentController@store')->name('comment.store');
Route::post('/comment/edit', 'CommentController@edit')->name('comment.edit');
Route::delete('/comment', 'CommentController@destroy')->name('comment.destroy');

Route::get('/search', 'SearchController@index')->name('search.index');
Route::get('/search/films', 'SearchController@films')->name('search.films');


Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/news/create', 'NewsController@create')->name('news.create');
    Route::post('/admin/news', 'NewsController@store')->name('news.store');
    Route::get('/news/{news}/edit', 'NewsController@edit')->name('news.edit');
    Route::post('/news/{news}/update', 'NewsController@update')->name('news.update');
    Route::delete('/news/{news}/destroy', 'NewsController@destroy')->name('news.destroy');

    Route::delete('/user/{user}/destroy', 'userController@destroy')->name('user.destroy');

    Route::post('/film/store', 'FilmController@store')->name('film.store');
    Route::get('/film/{film}/edit', 'FilmController@edit')->name('film.edit');
    Route::post('/film/update', 'FilmController@update')->name('film.update');
    Route::get('/film/create', 'FilmController@create')->name('film.create');
    Route::delete('/films', 'FilmController@destroy')->name('film.destroy');

    Route::post('/actor/store', 'ActorController@store')->name('actor.store');
    Route::get('/actor/create', 'ActorController@create')->name('actor.create');
    Route::get('/actor/{actor}/edit', 'ActorController@edit')->name('actor.edit');
    Route::post('/actor/{actor}/update', 'ActorController@update')->name('actor.update');
    Route::delete('/actor/{actor}/destroy', 'ActorController@destroy')->name('actor.destroy');

    Route::post('/film/{film}/cast/store', 'CastController@store')->name('cast.store');
    Route::get('/film/{film}/cast', 'CastController@create')->name('cast.create');
    Route::post('/cast/update', 'CastController@update')->name('cast.update');
    Route::delete('/cast/destroy', 'CastController@destroy')->name('cast.destroy');
    Route::get('/cast/autocomplete', 'CastController@autocomplete')->name('cast.autocomplete');

    //Route::get('/admin', 'AdminController@index')->name('admin.index');
    //Route::get('/admin/news', 'AdminController@newsShow')->name('admin.news.show');
    //Route::get('/admin/{news}', 'AdminController@newsShow')->name('admin.news.show');
    //Route::get('/admin/{news}/edit', 'AdminController@newsEdit')->name('admin.news.edit');
    //Route::get('/admin/{news}/destroy', 'AdminController@newsDestroy')->name('admin.news.destroy');
});

Route::get('/actor/{actor}', 'ActorController@show')->name('actor.show');

Route::get('/films', 'FilmController@index')->name('film.index');
Route::get('/film/{film}', 'FilmController@show')->name('film.show');
Route::post('/film/favourite', 'FilmController@favourite')->name('film.favourite');
Route::post('/film/want_to_see', 'FilmController@wantToSee')->name('film.want_to_see');
Route::get('/film/{film}/statistics', 'FilmController@statistics')->name('film.statistics');
