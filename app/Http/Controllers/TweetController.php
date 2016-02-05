<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection; 
use Illuminate\Support\Facades\Input;
use App\Tweet as Tweet;
use App\User as User;
use App\follow as Follow;
use Auth;
use DB;

class TweetController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function newTweet(Request $request)
    {   
        $user_id    = Auth::user()->id;
        $tweetData  = Input::all();
        $tweetData  = array_add($tweetData,'user_id',"$user_id");
        $newTweet   = Tweet::create($tweetData);

        $responseData = array();
        if($newTweet){
            $responseData['status']     = true;
            $responseData['message']    = "Tweeted";
        } else {
            $responseData['status']     = false;
            $responseData['message']    = "Cannot Tweet Right Now";
        }
        return response()->json($responseData);
    }

    
    public function deleteTweet(Request $request)
    {   
        $responseData = array();
        $tweet = Tweet::find($request->input('id'));
        if($tweet->user_id == $request->user()->id)
          if($tweet->delete()){
            $responseData['status']     = true;
            $responseData['message']    = "success";
          } else {
            $responseData['status']     = false;
            $responseData['message']    = "not success";
          } 
        else{
            $responseData['status']     = false;
            $responseData['message']    = "not success";
        } 
        return response()->json($responseData);
    }
}
