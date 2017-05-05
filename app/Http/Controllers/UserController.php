<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Picture;
use App\Models\Album;
use App\Models\Like;
use App\Models\Comment;

class UserController extends Controller
{
	
	public function __construct(){
		$this->middleware("auth");
	}
	
	public function showHome(){
		$user = Auth::user();
		/*
		$albums = Album::where("user_id", $user->id)->get();
		$pictures = Picture::where("user_id", $user->id)->get()->toArray();
		for($i=0; $i < count($pictures); $i++ ){
			$album = Album::where("id", $pictures[$i]["album_id"])->first()->toArray();
			
			$pictures[$i]["album_name"] = $album["name"];
			$pictures[$i]["album_id"] = $album["id"];
			$pictures[$i]["like"] = Like::where("picture_id", $pictures[$i]['id'])->count();
		}
		*/
		
		$albums = User::getAllAlbum($user->id);
		$pictures = User::getAllPicture($user->id)->toArray();
		for ($i = 0; $i < count($pictures); $i++ ){
			$album = Picture::getAlbum($pictures[$i]['album_id']);
			$pictures[$i]["album_name"] = $album->name;
			$pictures[$i]["album_id"] = $album->id;
			$pictures[$i]["numLike"] = Picture::getNumberOfLike($pictures[$i]['id']);
			
			//list($width, $height) = getimagesize(Storage::url($pictures[$i]['filePath']));
			//$pictures[$i]["width"] = $width;
			//$pictures[$i]["height"] = $height;
		}
		return view("home", ["user" => $user, "albums" => $albums, "pictures" => $pictures ]);
	}
	
	/*
	 *	Insert 1 row to Likes table
	 *	Return numberofLike
	 */
	public function like(Request $request)
	{
		$data = $request->all();
		if (!isset($data['picture_id'])){
			return Response::json(['title' => 'fail']);
		}
		$picture_id = $data['picture_id'];
		$picture = Picture::getPicture($picture_id);
		$user_id = Auth::user()->id;
		if($picture == NULL)
			return Response::json(['title' => 'like fail']); 
		
		$like = Like::where("picture_id", $picture_id)->where("user_id", $user_id)->first();
		if($like == NULL){
			Like::addLike($picture_id, $user_id);
			$button = "Liked";
		}
		else{
			Like::removeLike($picture_id, $user_id);
			$button = "Like";
		}
		$numLike = Picture::getNumberOfLike($picture_id);
		return Response::json([ 
			'title' => 'success', 
			'numLike' => strval($numLike),
			'button' => $button
		]);
	}
	
	public function comment(Request $request){
		$data = $request->all();
		if(!isset($data['picture_id']) || !isset($data['comment_content']) ){
			return Response::json(['title' => 'comment fail']);
		}
		/*
		 *	kiem tra cac gia tri picture_id, user_id hop le 
		 */
		$picture = Picture::where("id", $data['picture_id'])->first();
		if($picture == NULL)
			return Response::json(['title' => 'comment fail']);
		$user = Auth::user();
		$comment = Comment::addComment($picture->id, $user->id, $data['comment_content']);
		return Response::json([
			"title" => "success",
			"picture_id" => $picture->id,
			"user_name" => $user->name,
			"user_id"	=> $user->id,
			"comment_content" => $comment->content,
			"created_at"	=> $comment->created_at,
		]);
	}
}
