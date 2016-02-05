<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\User as User;

	class Tweet extends Model{
		protected $fillable = [
		        'user_id', 'message',
		    ];
		public function user(){
			return $this->belongsTo('App\User');
		}
	}
?>