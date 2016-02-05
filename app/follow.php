<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class follow extends Model
{
    protected $fillable = [
        'user_id', 'follow_user_id',
    ];

    public static function isFollowing($followData) {
    	$followed = Follow::where('user_id',$followData['user_id'])
    			->where('follow_user_id',$followData['follow_user_id']);
        if($followed->first())
            return true;
        else{
        	return false;
        }
    }

    public static function unFollow($followData){
    	$followed = Follow::where('user_id',$followData['user_id'])
    			->where('follow_user_id',$followData['follow_user_id']);
    	if($followed->delete()){
    		return true;
    	} else {
    		return false;
    	}
    }
}
