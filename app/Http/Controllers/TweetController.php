<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection; 
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
        $tweet                  = new Tweet;
        $tweet->message         = $request->input('tweetMessage');
        $tweet->user_id         = Auth::User()->id;
        $tweet->save();
        return "success";
    }
    public function deleteTweet(Request $request)
    {   
        $tweet = Tweet::find($request->input('id'));
        if($tweet->user_id == $request->user()->id)
          if($tweet->delete())
            return "success";
          else return "not success";
        else return "not success";
    }
    
}
