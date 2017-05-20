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
	
	public function showUpdateWallpaperForm(Request $request){
		$user = Auth::user();
		$pictures = User::getAllPicture($user->id);
		return view ("editwallpaper", [ 'user' => $user, 'pictures' =>$pictures]);
	}
	public function updateWallpaper(Request $request){
		$user = Auth::user();
		
		$validator = Validator::make($request->all(), [
			'picture_id' => "required"
		]);
		$data = $request->all();
		if($validator->fails()){
			$pictures = User::getAllPicture($user->id);
			return redirect("/editwallpaper")->withErrors($validator);
			//return view ("editwallpaper",['user' => $user, 'pictures' => $pictures]);
		}
		if ($data['picture_id'] === $user->wallpaper){
			// no change
		}
		else{
			$picture = Picture::where('user_id', $user->id)->where('id', $data['picture_id'])->first();
			if ($picture == NULL){
				return "Invalid picture";
			}
			$user->update(['wallpaper' => $picture->filePath]);
		}
		return redirect('/profile');
	}
	public function showUpdateProfileForm(Request $request){
		$user = Auth::user();
		$pictures = User::getAllPicture($user->id);
		return view("editprofile", ['user' => $user, 'pictures' => $pictures]);
	}
	
	public function updateProfile(Request $request)
	{
		$validator = Validator::make($request->all(), [
			
			'user_name' => 'required|max:255',
			'picture_id' => "required"
		]);
		$data = $request->all();
		if($validator->fails()){
			return redirect("/editprofile")->withErrors($validator);
			return "validate fail";
		}
		$user = Auth::user();
		if ($data['picture_id'] === $user->avatar)
			$user->update(['name' => $data['user_name'] ]);
		else{
			$picture = Picture::where('user_id', $user->id)->where('id', $data['picture_id'])->first();
		
			if ($picture == NULL){
				return "Invalid picture";
			}
			$user->update(['name' => $data['user_name'], 'avatar' => $picture->filePath]);
		}
		return redirect('/profile');
	}
	
	public function showDeletePicture(Request $request){
		$data = $request->all();
		if(!isset($data['picture_id'])){
			return "No picture is set";
		}
		$picture = Picture::getPicture($data['picture_id']);
		if($picture == NULL){
			return "Invalid picture";
		}
		else 
			return view('deleteimage', [ 'picture' => $picture ]);
		
	}
	
	public function showEditAlbum(Request $request)
	{
		$user = Auth::user();
		$pictures = User::getAllPicture($user->id)->toArray();
		
		return view('editalbum', ['pictures' => $pictures]);
	}
	
	public function showEditPicture(Request $request)
	{
		$data = $request->all();
		if(!isset($data['picture_id'])) {
			return "Không có ảnh nào được chọn.!!! ";
		}
		$picture = Picture::getPicture($data['picture_id']);
		if($picture == NULL){
			return "Ảnh không đúng!!!";
		}
		return view('editimage', ['picture' => $picture->toArray()]);
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
		$user_id = Auth::user()->id;
		$albums = User::getAllAlbum($user->id);
		$pictures = User::getAllPicture($user->id)->toArray();
		for ($i = 0; $i < count($pictures); $i++ ){
			$album = Picture::getAlbum($pictures[$i]['album_id']);
			$pictures[$i]["album_name"] = $album->name;
			$pictures[$i]["album_id"] = $album->id;
			$pictures[$i]["numLike"] = Picture::getNumberOfLike($pictures[$i]['id']);
			
			$button = Like::where("picture_id", $pictures[$i]['id'])
						->where("user_id", $user_id)->first();
			if($button == NULL){
				$pictures[$i]['button'] = "Like";
			}
			else 
				$pictures[$i]['button'] = "Liked";
			//list($width, $height) = getimagesize(Storage::url($pictures[$i]['filePath']));
			//$pictures[$i]["width"] = $width;
			//$pictures[$i]["height"] = $height;
		}
		return view("profile", ["user" => $user, "albums" => $albums, "pictures" => $pictures ]);
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
			return Response::json(['title' => 'comment fail - not set ']);
		}
		/*
		 *	kiem tra cac gia tri picture_id, user_id hop le 
		 */
		$picture = Picture::where("id", $data['picture_id'])->first();
		if($picture == NULL)
			return Response::json(['title' => 'comment fail - no id']);
		$user = Auth::user();
		$comment = Comment::addComment($picture->id, $user->id, $data['comment_content']);
		return Response::json([
			"title" => "success",
			"picture_id" => $picture->id,
			"user_name" => $user->name,
			"user_id"	=> $user->id,
			"user_avatar" => url('/') . '/storage/' . $user->avatar,
			"comment_content" => $comment->content,
			"created_at"	=> $comment->created_at,
		]);
	}
	
	public function updatePicture(Request $request){
		//return "test";
		//$this->validateUpdatePicture($request);
		
		//if($this->validateUpdatePicture($request)){
		$validator = Validator::make($request->all(), [
			'picture_id'=> 'required',
			'description' => 'required',
			'privilege' => "required|between:0,1"
		]);
		if($validator->fails()){
			return "validate fail";
		}
		$data= $request->all();
		if(Picture::updatePicture($data) ){
			return redirect("/profile");
					
		}
		else 
			return "Invalid picture - update ";
		
	}
	
	public function deletePicture(Request $request)
	{
		$data = $request->all();
		if( !isset($data['picture_id']) ){
			return "No picture is set";
		}
		if(Picture::deletePicture($data['picture_id'])){
			$user = Auth::user();
			$pictures = User::getAllPicture($user->id)->toArray();
			
			return view('editalbum', ['pictures' => $pictures]);
			
		}
		else 
			return "Invalid picture";
	}
}
