<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/checkEmail','Controller@checkEmail');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::match(['get','post'],'/home', 'HomeController@index');
    Route::get('/allUsers','HomeController@allUsers');
    Route::post('/newTweet','HomeController@newTweet');
    Route::post('/newFollow','HomeController@newFollow');
    Route::get('/imageUpload','HomeController@imageUpload');
    Route::post('/uploadImage','HomeController@uploadImage');
});
