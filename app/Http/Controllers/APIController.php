<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\Picture;
use App\Models\User;
use App\Models\Like;
use App\Models\Album;
use App\Models\Comment;
class APIController extends Controller
{
    //
	public function __construct(){
		$this->middleware("auth:api");
	}
	public function apiComment(Request $request){
		$data = $request->all();
		$validator = Validator::make($data, [
			'picture' => 'required|integer',
			'content' => 'required'
		]);
		if($validator->fails()){
			return response()->json('Input is not set', 422);
		}
		if(!isset($data['picture']) || !isset($data['content']) ){
			
		}
		
		/*
		 *	kiem tra cac gia tri picture_id, user_id hop le 
		 */
		$picture = Picture::where("id", $data['picture'])->first();
		if($picture == NULL)
			return response()->json('Picture is not found', 404);
		$user = Auth::guard('api')->user();
		$comment = Comment::addComment($picture->id, $user->id, $data['content']);
		return response()->json('Success', 200);
	}
	
	public function apiLike(Request $request){
		$data = $request->all();
		if(!isset($data['picture'])){
			return response()->json('Picture Is Not Set', '422');
		}
		$picture_id = $data['picture'];
		$picture = Picture::getPicture($picture_id);
		$user_id = Auth::guard('api')->user()->id;
		if($picture == NULL)
			return response()->json('Picture is not found', 404);
		
		$like = Like::where("picture_id", $picture_id)->where("user_id", $user_id)->first();
		if($like == NULL){
			Like::addLike($picture_id, $user_id);
		}
		else{
			Like::removeLike($picture_id, $user_id);
		}
		$numLike = Picture::getNumberOfLike($picture_id);
		return Response::json([ 
			'title' => 'success', 
			'numLike' => strval($numLike),
		]);
		return response()->json(['title' => 'success', 'numLike' => strval($numLike)], 200);
	}
	
	public function apiUploadPicture(Request $request){
		$data = $request->all();
		$validator = Validator::make($data, [
			'description' => 'max:1024',
			'filePath' => 'required',
			'privilege' => 'required|integer|between:0,1',
			'image' => 'required|mimes:png,jpeg,jpg,gif|max:10240',
//			'album_id' => 'required|integer|between:0,10000',
		]);
		
		if ($validator->fails()){
			return response()->json('Invalid Input', 400);
		}
		
		$file = $request->file("image");
		$filePath = $file->store('image/' . $user->id);
		$user = Auth::guard('api')->user();
		// album đầu tiên được chọn là mặc định
		$album = Album::where('user_id', $user->id)->first();
		//$newFilePath = 'image/' . $user->id . '/' . $fileName;
		//Storage::move($filePath, $newFilePath);
		Picture::create([
			'description' => $data['description'],
			'filePath' => $filePath,
			'privilege' => $data['privilege'],
			'user_id' => $user->id,
			'album_id' => $album->id,
		]);
		
		return response()->json('Success');
	}
	
	
	
}
