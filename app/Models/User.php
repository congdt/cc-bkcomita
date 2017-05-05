<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Model;
//use Moloquent;

class User extends Model implements Authenticatable
{
	use AuthenticatableTrait;
    //
	//protected $connection = "mongodb";
	protected $fillable = [
		"name",
		"password",
		"email"
	];
	
	public static function getUser(String $user_id){
		return User::where("id", $user_id)
					->first();
	}
	
	public static function getAllPicture(String $user_id){
		return Picture::where("user_id", $user_id)
					->orderBy("created_at", "desc")->get();
	}
	public static function getPublicPicture(String $user_id){
		return Picture::where("user_id", $user_id)
						->where("privilege", 0)
						->orderBy("created_at", "desc")->get();
	}
	
	public static function getAllAlbum(String $user_id){
		return Album::where("user_id", $user_id)->get();
	}
	public static function getPublicAlbum(String $user_id){
		return Album::where("user_id", $user_id)
						->where("privilege", 0)->get();
	}
}
