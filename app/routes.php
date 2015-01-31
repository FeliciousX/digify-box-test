<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'index', 'uses' => 'HomeController@index'));

Route::get('/login', array('as' => 'login', 'uses' => 'AuthController@loginWithBox'));
Route::any('/logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));

Route::group(['before' => 'auth'], function() {
    Route::get('/oauth/refresh', ['as' => 'oauth.refresh', 'uses' => 'AuthController@refreshToken']);
    Route::resource('box', 'BoxAPIController');
    Route::resource('photo', 'PhotoController');
});


