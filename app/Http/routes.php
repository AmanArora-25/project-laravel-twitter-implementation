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

    //Routes for UserController
    Route::match(['get','post'],'/home', 'UserController@index');
    Route::get('/allUsers','UserController@allUsers');
    Route::post('/newFollow','UserController@newFollow');
    Route::post('/unFollow','UserController@unFollow');
    Route::get('/imageUpload','UserController@imageUpload');
    Route::post('/uploadImage','UserController@uploadImage');    

    //Routes for TweetController
    Route::post('/newTweet','TweetController@newTweet');
    Route::post('/deleteTweet','TweetController@deleteTweet');
});
