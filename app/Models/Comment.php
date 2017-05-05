<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
	protected $fillable = [
		'picture_id',
		'user_id',
		'content'
	];
	
	/*
	 *	Trả về các đối tượng record
	 *	return user_id & user name of user commented
	 */
	public static function getUserComment(String $picture_id){
		return Comment::join("users", "comments.user_id", "=", "users.id")
				->select("users.id as user_comment_id", "users.name as user_comment_name")
				->where("comments.picture_id", "=", $picture_id)
				->orderBy("comments.created_at", "desc")
				->get();
	}
	
	public static function addComment(String $picture_id, String $user_id, String $content){
		return Comment::create([
			'picture_id' => $picture_id,
			'user_id' => $user_id,
			'content' => $content,
			
		]);
	}
	
	public static function getComment(String $picture_id, String $user_id){
		return Comment::where('picture_id', $picture_id)->where('user_id', $user_id)->first();
	}
	
	
}
