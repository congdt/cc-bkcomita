<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Models\User;
//use App\Models\Album;
//use App\Models\Like;
//use App\Models\Comment;
//use Moloquent;

class Picture extends Model
{
    //
	//protected $connection = "mongodb";
	protected $fillable = [
		"description",
		"privilege",
		"filePath",
		"user_id",
		"album_id"
	];
	
	
	protected static function boot(){
		parent::boot();
		
		static::deleting(function($picture){
			$picture->getLike($picture->id)->delete();
			$picture->getComment($picture->id)->delete();
		} );
	}
	
	// them anh vao Picture collection 
	public static function getPicture(String $picture_id){
		return Picture::where("id", $picture_id)->first();
	}
	
	public static function updatePicture(array $data){
		$picture = Picture::getPicture($data['picture_id'])->first();
		if($picture == NULL){
			return false;
		}
		else{
			Picture::where("id", $data['picture_id'])
					->first()
					->update(["description" => $data['description'], "privilege" => $data['privilege'] ]);
			return true;
		}
	}
	
	public static function deletePicture(String $picture_id){
		$picture = Picture::getPicture($picture_id);
		if( $picture == NULL){
			return false;
		}
		else{
			Like::where("picture_id", $picture_id)->delete();
			Comment::where("picture_id", $picture_id)->delete();
			Picture::where("id", $picture_id)->delete();
			return true;
		}
	}
	public static function getUser(String $user_id){
		return User::where("id", $user_id)->first();
	}
	public static function getAlbum(String $album_id){
		return  Album::where("id", $album_id)->first();
	}
	public static function getNumberOfLike(String $picture_id){
		return Like::where("picture_id", $picture_id)->count();
	}
	/*
	 *	get username & user_id of users liked $picture_id
	 */
	public static function getUserLike(String $picture_id){
		return Like::join("users", "likes.user_id", "=", "users.id")
				->select("users.id", "users.name")
				->where("likes.picture_id", "=", $picture_id)
				->orderBy("likes.created_at")
				->get();
	}
	
	/*
	 *	return users.id & users.name
	 *	comments.created_at, comments.content 
	  *	of user commented
	 */
	public static function getComment(String $picture_id){
		return Comment::join("users", "comments.user_id", "=", "users.id")
				->select("users.id", "users.name", "comments.content", "comments.created_at")
				->where("comments.picture_id", "=", $picture_id)
				->orderBy("comments.created_at")
				->get();
	}
	
	public static function getAllPublicPicture()
	{
		return Picture::where("privilege", 0)
				->orderBy("created_at", "desc")
				->get();
	}
	/*
	 *	Trả về các đối tượng record Comment 
	 */
	public static function getAllComment(String $picture_id){
		return Comment::where("picture_id", $picture_id)
					->orderBy("created_at", "desc")
					->get();
	}
}
	