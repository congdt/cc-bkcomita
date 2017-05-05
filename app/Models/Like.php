<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
	protected $fillable = [
		'picture_id',
		'user_id',
		
	];
	
	/*
	 *	return username & user_id of all user like $picture_id
	 */
	public static function getUserLike(String $picture_id){
		//$users = Like::select("user_id")->where("picture_id", $picture_id)->get();
		return Like::join("users", "likes.user_id", "=", "users.id")
				->select("users.id", "users.name")
				->where("likes.picture_id", "=", $picture_id)
				->orderBy("likes.created_at", "desc")
				->get();
	}
	
	// ko kiem tra gia tri $picture_id co hop le hay ko trong ham nay  
	public static function addLike(String $picture_id, String $user_id){
		Like::create([
			"picture_id" => $picture_id,
			"user_id"	=>	$user_id
		]);
	}
	
	public static function removeLike(String $picture_id, String $user_id){
		Like::where('picture_id', $picture_id)->where('user_id', $user_id)->delete();
		
	}
}
