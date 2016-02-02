<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Tweet as Tweet;
use App\User as User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function checkEmail(Request $request){
        $users = User::all()->where('email',$request->input('email'));
        if($users->first()){
            return "true";
        } else {
            return "false";
        }
    }
}
