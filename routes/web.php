<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('index', "GuestController@showIndex");
Route::get('/', "GuestController@showIndex");
Route::get("/user/{user_id}", "GuestController@showUserPage")
	->where(["user_id" => "[0-9]+"]);

/* ----------- Activate Route -----------------------------*/
Route::get("send", "EmailController@send");
Route::get("activate/{token}", "ActivationController@activateUser");
Route::get("waitforactivate", function(){
	return "Please active by email";
});
Route::get("fail", function(){
	return "Fail";
} );

/*----------- Upload Route ---------------- */
Route::get("uploadForm", "PictureController@showUploadForm");
Route::post("storePic", "PictureController@store");
Route::post("showPic", "PictureController@showPic");
//Route::get("showLists", "PictureController@show");


/*------------ Modify Picture, User info, Alubm ---------*/
//Route::get('/home', 'UserController@showHome');

Route::post("like", "UserController@like");
Route::post("comment", "UserController@comment");

Route::get("loadComment", "GuestController@loadComment");

Route::get("profile", "UserController@showHome");

Route::get("editprofile", "UserController@showUpdateProfileForm");
Route::post("editprofile", "UserController@updateProfile");
Route::get("editwallpaper", "UserController@showUpdateWallpaperForm");
Route::post("editwallpaper", "UserController@updateWallpaper");
Route::get("editalbum", "UserController@showEditAlbum");
Route::get("editimage", "UserController@showEditPicture");
Route::post("updatePicture", "UserController@updatePicture");
Route::get("deleteimage", "UserController@showDeletePicture");
Route::post("deleteimage", "UserController@deletePicture");
/* ----------- Get Picture, User info, Album ------------------ */
//Route::get("/{user_id}/", "UserController@showUser");
//Route::get("/{user_id}/{album_id}", "UserController@showUserAlbum");

//Route::get("admin", "UserController@adminshow");
//Route::post("admin", "UserController@adminstore");

/* ---------------- Auth Route -------------------*/
Auth::routes();

