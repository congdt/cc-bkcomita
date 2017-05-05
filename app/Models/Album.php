<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    //
	protected $fillable = [
		'user_id',
		'name',
		'privilege'
	];
	
	public static function getAlbum(String $album_id){
		return Album::where("id", $album_id)->first();
	}
	
	public static function getAllPicture(String $album_id){
		return Picture::where("album_id", $album_id)->get();
	}
	public static function getPublicPicture(String $album_id){
		return Picture::where("album_id", $album_id)
						->where("privilege", 0)->get();
	}
	
	
}
