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

class HomeController extends Controller
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
    function msort($array, $key, $sort_flags = SORT_REGULAR) {
        if (is_array($array) && count($array) > 0) {
            if (!empty($key)) {
                $mapping = array();
                foreach ($array as $k => $v) {
                    $sort_key = '';
                    if (!is_array($key)) {
                        $sort_key = $v[$key];
                    } else {
                        // @TODO This should be fixed, now it will be sorted as string
                        foreach ($key as $key_key) {
                            $sort_key .= $v[$key_key];
                        }
                        $sort_flags = SORT_STRING;
                    }
                    $mapping[$k] = $sort_key;
                }
                asort($mapping, $sort_flags);
                $sorted = array();
                foreach ($mapping as $k => $v) {
                    $sorted[] = $array[$k];
                }
                return $sorted;
            }
        }
        return $array;
    }
    public function index(Request $request)
    {   
        $user               = $request->user();
        $follows            = $user->followers();
        $followscollection  = $follows->get();
        $followscollection->add($user);
        $tweets             =array();
        foreach ($followscollection as $follower) {
            foreach($follower->tweets()->get() as $tweet){
                $tweetData                  = array();
                $tweetData['name']          = $tweet->user->name;
                $tweetData['message']       = $tweet->message;
                $tweetData['created_at']    = $tweet->created_at;
                $tweets[] = $tweetData;
            }
        } 
        $homeData               = array();
        $tweets = $this->msort($tweets,array('created_at'));
        $tweets = array_reverse($tweets);
        $homeData['tweets']     = $tweets;
        return view('home',$homeData);
    }
    public function allUsers(Request $request)
    {   
        $users                  = User::where('id','<>',$request->user()->id)->paginate(2);
        $allUsers               = array('allUsers'=>$users);
        return view('allUsers',$allUsers);
    }
    public function newTweet(Request $request)
    {   
        $tweet                  = new Tweet;
        $tweet->message         = $request->input('tweetMessage');
        $tweet->user_id         = Auth::User()->id;
        $tweet->save();
        return "success";
    }
    public function newFollow(Request $request){
        $followed = Follow::where('user_id',$request->user()->id)->where('follow_user_id',$request->input('id'));
        if($followed->first())
            return "Already Followed";
        else{
            DB::table('follows')->insert(
            ['user_id' => $request->user()->id, 'follow_user_id' => $request->input('id')]
            );
            return "followed";
        }
    }
    public function imageUpload(Request $request){
        return view('imageUpload');
    }
    public function uploadImage(Request $request){
        $photo = $request->file('file');
        return redirect('/home');
    }
    
    
}
