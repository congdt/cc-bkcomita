<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Picture;
use App\Models\Album;
use App\Models\User;
use Carbon\Carbon;

class PictureController extends Controller
{
    //
	public function __construct(){
		$this->middleware('auth');
	}
	public function showUploadForm(){
		$user = Auth::user();
		$albums = Album::where("user_id", $user->id)->get();
		
		return view("chooseimage", ["user" => $user, "albums" =>  $albums]);
	}
	// chooseimage gửi file ảnh lên
	// show anh trong file public image 
	// nếu ấn post => route post("uploadForm", "PictureController@store")
	public function showPic(Request $request){
		//$this->validator($request->all())->validate();
		$validator = Validator::make($request->all(), [
			'image' => 'required|mimes:png,jpeg,jpg,gif|max:10240'
		]);
		if($validator->fails()){
			return redirect('uploadForm')->withErrors($validator);
		}
		$data = $request->all();
		$user = Auth::user();
		
		if($request->hasFile("image")){
			$file = $request->file("image");
			$filePath = $file->store('tmp/' . $user->id);
		}
		return view("postimage", ["user" => $user, "filePath" => $filePath]);
	}
	
	public function store(Request $request){
		/*
		$this->validator($request->all())->validate();
		$data = $request->all();
		$user = Auth::user();
		
		if($request->hasFile("image")){
			$file = $request->file("image");
			
			$album = Album::where('user_id', $user->id)->where('id', $data['album_id'])->first();
			if($album == NULL){
				return "Invalid Album";
			}
			$filePath = $file->store('image/' . $user->id );
			Picture::create([
				'description' => $data['description'],
				'filePath' => $filePath,
				'privilege' => $data['privilege'],
				'user_id' => $user->id,
				'album_id' => $album->id,
			]);
		}
		*/
		
		$data = $request->all();
		$validator = Validator::make($data, [
			'description' => 'max:1024',
			'filePath' => 'required',
			'privilege' => 'required|integer|between:0,1',
//			'album_id' => 'required|integer|between:0,10000',
		]);
		
		if ($validator->fails()){
			return redirect('postimage')->with('filePath', $filePath)->withErrors($validator);
		}
		
		$filePath = $data['filePath'];     // cần kiểm tra file tồn tại 
		//return $filePath;
		if (!Storage::exists($filePath)){
			return "File not exist.";
		}
		
		$fileName = basename($filePath);
		
		$user = Auth::user();
		// album đầu tiên được chọn là mặc định
		$album = Album::where('user_id', $user->id)->first();
		$newFilePath = 'image/' . $user->id . '/' . $fileName;
		Storage::move($filePath, $newFilePath);
		Picture::create([
			'description' => $data['description'],
			'filePath' => $newFilePath,
			'privilege' => $data['privilege'],
			'user_id' => $user->id,
			'album_id' => $album->id,
		]);
		//$albums = User::getAllAlbum($user->id);
		//return $this->create()->with("success", "Image Upload Successfully");
		//return view("uploadForm", [ "success" => "Image Upload Successfully", "albums" => $albums]);
		return redirect('index');
	}
	
	
	protected function validateUpdatePicture(Request $request){
		return $this->validate($request, [
				'operation'=>'required',
				'picture_id'=> 'required',
				'description' => 'required',
				'privilege' => 'required|in:0,1'] );
	}
	
	protected function validator($data){
		return Validator::make($data, [
            'description' => 'max:1024',
//			'image' => 'required|mimes:png,jpeg,jpg|max:2000',
			'filePath' => 'required',
			'privilege' => 'required|integer|between:0,1',
			'album_id' => 'required|integer|between:0,10000',
        ]);
	}
}
