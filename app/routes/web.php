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


Route::get('/', 'PostController@index')->name('top');

Auth::routes();

Route::get('/suspended', 'Auth\LoginController@suspended')->name('suspended');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/posts', 'PostController@index')->name('posts.index');

Route::group(['middleware' => ['auth', 'check.status']], function() {
    Route::resource('posts', 'PostController')->except(['index', 'show']);
});

Route::get('/posts/{post}', 'PostController@show')->name('posts.show');

Route::group(['middleware' => ['auth', 'check.status']], function() {
    Route::resource('posts', 'PostController')->except(['index', 'show']);

    Route::post('/posts/{post}/bookmark', 'BookmarkController@store')->name('bookmarks.store');
    Route::delete('/posts/{post}/bookmark', 'BookmarkController@destroy')->name('bookmarks.destroy');
    Route::get('/bookmarks', 'BookmarkController@index')->name('bookmarks.index');

    Route::post('/posts/{post}/comments', 'CommentController@store')->name('comments.store');

    Route::get('/mypage', 'UserController@mypage')->name('mypage');
    Route::get('/users/{id}', 'UserController@show')->name('users.show');

});

Route::group(['middleware' => ['auth', 'check.status']], function(){
    Route::get('/admin/top', 'AdminController@top')->name('admin.top');
    Route::get('/admin/posts', 'AdminController@postsIndex')->name('admin.posts.index');

    Route::post('/admin/posts/{post}/hide', 'AdminController@hidePost')->name('admin.posts.hide');
    Route::post('/admin/posts/{post}/show', 'AdminController@showPost')->name('admin.posts.show');

    Route::get('/admin/users', 'AdminController@usersIndex')->name('admin.users.index');
    Route::post('/admin/users/{user}/toggle', 'AdminController@toggleUserStatus')->name('admin.users.toggle');
});

Route::get('/posts/{post}/report', 'ReportController@create')
    ->middleware('auth')
    ->name('reports.create');

Route::post('/posts/{post}/report', 'ReportController@store')
    ->middleware('auth')
    ->name('reports.store');

Route::middleware('auth')->group(function (){
    Route::get('/mypage', 'UserController@mypage')->name('mypage');

    Route::get('/user/edit', 'UserController@edit')->name('user.edit');
    Route::post('/user/update', 'UserController@update')->name('user.update');

    Route::get('/user/withdraw', 'UserController@withdrawConfirm')->name('user.withdraw.confirm');
    Route::post('/user/withdraw', 'UserController@withdraw')->name('user.withdraw');
});




