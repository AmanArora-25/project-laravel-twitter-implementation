<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection; 
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

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

    public function index(Request $request)
    {   
        $user               = $request->user();
        $follows            = $user->followers();
        $followers  = $follows->get();
        $followers->prepend($user);
        $allTweets = new Collection;

        foreach($followers as $follower){
          $allTweets->prepend($follower->tweets);
        }
        $tweets = new Collection;
        foreach ($allTweets as $tweet) {
          foreach ($tweet as $key => $value) {
            $tweets->prepend($value);
          }
        }
        $tweets = $tweets->sortByDesc('created_at');
        $homeData = array();
        $homeData['tweets']       = $tweets;
        $homeData['path_image']   = storage_path('photos');
        return view('home',$homeData);
    }

    public function allUsers(Request $request)
    {   
        $users                  = User::allUsers(2);
        $allUsers               = array('allUsers'=>$users);
        return view('allUsers',$allUsers);
    }

    public function newFollow(Request $request){

      $followData                   = Input::all(); 
      $user_id                      = Auth::user()->id; 
      $followData                   = array_add($followData,'user_id',"$user_id");

      $responseData                 = array();

      if(Follow::isFollowing($followData)){
        $responseData['status']     = false;
        $responseData['message']    = "Already Followed";
      } else {
        Follow::firstOrCreate($followData);
        $responseData['status']     = true;
        $responseData['message']    = "Followed";
      }
      return response()->json($responseData);
    }
    public function unFollow(Request $request){
      $followData = Input::all(); 
      $user_id    = Auth::user()->id; 
      $followData = array_add($followData,'user_id',"$user_id");

      $responseData                 = array();

      if(Follow::isFollowing($followData)){
        if(Follow::unfollow($followData)){
          $responseData['status']   = true;
          $responseData['message']  = "unfollowed";
        } else {
          $responseData['status']   = false;
          $responseData['message']  = "please try again later";
        } 
      } else {
          $responseData['status']   = false;
          $responseData['message']  = "You dont follow this user";;
      } 
      return response()->json($responseData);
    }
    public function imageUpload(Request $request){
        $user = User::find($request->User()->id);
        return view('imageUpload');
    }
    public function uploadImage(Request $request){
        if($request->hasFile('file')){
          $photo      = $request->file('file');
          $photoName  = uniqid().$photo->getClientOriginalName() ;
          $photo->move('../storage/photos',$photoName);
        } else {
          $photoName = "defaultPhoto.jpg";
        }
        $user = User::find($request->user()->id);
        $user->photo = $photoName;
        $user->save();
        return redirect('/home');
    }
    
    function getProfilePhoto(Request $request,$userID){
        $filepath = storage_path() . '/photos/' . User::find($userID)->photo;
        return Response()->download($filepath);
      }
    
}
