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

//Move this to users controller
Route::post('/check_email',['as'=>'email.check', 'uses'=>'Controller@checkEmail']);

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

    //Routes for Users
    Route::match(['get','post'],'/home', 'UserController@index');
    Route::get('/users',['as'=>'users.all', 'uses'=> 'UserController@allUsers']);

    //Routes for Images
    Route::get('/image/upload',['as' =>'image.upload', 'uses' => 'UserController@imageUpload']);
    Route::post('/uploadimage','UserController@uploadImage');   

    //Routes for Followers
    Route::post('/follow', ['as' => 'user.follow', 'uses' => 'UserController@newFollow']); 
    Route::post('/unfollow', ['as' => 'user.unfollow', 'uses' => 'UserController@unFollow']); 

    //Routes for Tweets
    Route::post('/tweet/new',['as'=>'tweet.new', 'uses'=>'TweetController@newTweet']);
    Route::post('/tweet/delete',['as'=>'tweet.delete', 'uses'=> 'TweetController@deleteTweet']);
    Route::get('images/profile/{userID}', 'UserController@getProfilePhoto'); 
});
