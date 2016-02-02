<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\User as User;

	class Tweet extends Model{

		public function user(){
			return $this->belongsTo('App\User');
		}
	}
?>