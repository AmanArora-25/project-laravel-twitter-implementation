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

class UserController extends Controller
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
                if(empty($tweet->user->photo)){
                  $tweetData['photo']         = "defaultPhoto.jpg";
                } else {
                  $tweetData['photo']         = $tweet->user->photo;
                }
                $tweetData['id']            = $tweet->id;
                $tweetData['name']          = $tweet->user->name;
                $tweetData['user_id']       = $tweet->user_id;
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


        //$users = User::getAllUsers();

        //$user = new User('name' => 'Gaurav');
        //$user->save();

        //$users                  = User::where('id','<>',$request->user()->id)->paginate(2);
        $users                  = User::allUsers()->paginate(2);
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
    public function unFollow(Request $request){
        $followed = Follow::where('user_id',$request->user()->id)->where('follow_user_id',$request->input('id'));
        if($followed->first()){
          if($followed->delete())
            return "unfollowed";
        } else return "not found";
    }
    public function imageUpload(Request $request){
        $user = User::find($request->User()->id);
        if($user->photo){
          if($user->photo=="defaultPhoto.jpg"){
            return view('imageUpload');
          }
          else return redirect('/home');
        }    
        else{
            return view('imageUpload');
        }
    }
    public function uploadImage(Request $request){
        if($request->hasFile('file')){
          $photo      = $request->file('file');
         //dd($request->hasFile('file'));
          $photoName  = uniqid().$photo->getClientOriginalName() ;
          $photo->move('gallery/images',$photoName);
        } else {
          $photoName = "defaultPhoto.jpg";
        }
        $user = User::find($request->user()->id);
        $user->photo = $photoName;
        $user->save();
        return redirect('/home');
    }
    
    
}
