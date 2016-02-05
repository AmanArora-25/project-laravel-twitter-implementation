<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Tweet as Tweet;
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','photo',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tweets(){
        return $this->hasMany('App\Tweet');
    }
    public function followers(){
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'follow_user_id');
    }
    public static function allUsers($page = 10){
        return User::where('id','<>',Auth::user()->id)->paginate($page);
    }
}
