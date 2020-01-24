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

Route::get('/', 'BloggersController@index')->name('main');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('login', function () {
    return view('auth.login');
})->name('login');

Auth::routes();

Route::group(
    ['prefix' => '/api'],
    function () {
        Route::resource('channels', 'Api\ChannelController');
        Route::post('/channels/{channel}/getVideos/', 'Api\ChannelController@getVideos')->name('channels.getVideos');
        Route::post('/channels/channelsDefault/', 'Api\ChannelController@channelsDefault')->name('channels.channelsDefault');

        Route::resource('comments', 'Api\CommentController');

        Route::resource('files', 'Api\FileController');
        Route::get('/files/{id}/download', 'Api\FileController@download')->name('files.download');

        Route::resource('users', 'Api\UserController');
        Route::post('/users/{user}/getSubscribes/', 'Api\UserController@getSubscribes')->name('users.getSubscribes');
    }
);

Route::get('/youtube/auth/', 'Auth\AuthController@YoutubeAuth');
Route::get('/youtube/callback/', 'Auth\AuthController@YoutubeCallback');