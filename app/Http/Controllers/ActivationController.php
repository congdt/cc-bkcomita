<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pending;
use App\Models\Album;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
//use Illuminate\Mail\Mailer;

class ActivationController extends Controller 
{
    //
	private $expire_time = 5; // minutes
	
	
	/*
	 * 	Tao va tra ve 1 token ngau nhien 
	 */
	private function generateToken(){
		return hash_hmac('sha256', str_random(40), config('app.key'));
	}
	
	/*
	 *	gui mail 
	 */
	public function sendActivationMail($data){
		$pending_user = $this->createPendingUser($data);
		if($pending_user->activated ){
			return 0;
		}
		$token = $pending_user['token'];
		//$link = route('activate', $token);
		$link = url('/') . '/activate/' . $token;
		$content = "Activate link : " . $link;
		Mail::send("activationMail", ['content' => $content], function($message) use ($pending_user){
			//$message->from("bkcomita@epic.persec.com", "BKCoMiTa Team");
			$message->from("epic.co@epic.persec.com", "BKCoMiTa Team");
			$message->to($pending_user->email);
		});
		if(Mail::failures()){
			return 1;
		}
		return 2;
	}
	
	/*
	 *	Tao mot record trong Pending table
	 *	Tra ve doi tuong PendingUser
	 */
	public function createPendingUser(array $data){
		$token = $this->generateToken();
		$now = Carbon::now();
		$expires = $now->addMinutes($this->expire_time);
		return Pending::create([
			'name' => $data['name'],
			'password' => bcrypt($data['password']),
			'email' => $data['email'],
			'expires' => $expires,
			'token' => $token
		]);
	}
	
	/*
	 *	Tao token moi va luu vao csdl pending_user goi 
	 *	va dat lai expire time moi 
	 */
	protected function resetToken(array $pending_user){
		$token = $this->generateToken();
		$expires = Carbon::now()->addMinutes($this->expire_time);
		Pending::where('email', $pending_user['email'])
				->update(['token' => $token, 'expires' => $expires]);
	}
	
	/*
	 * 	Kich hoat user dang cho 
	 *	 - Neu dung $token 
	 * 	 + Tao record moi cho bang User 
	 *	 + xoa record pending trong bang pending
	 */
	public function activateUser(String $token){
		
		$pending_user = Pending::where('token', $token)->first();
		if($pending_user != NULL){	
			$user = User::create([
				'name' => $pending_user['name'],
				'email' => $pending_user['email'],
				'password' => $pending_user['password'],
				'avatar' => 'default_avatar.png',
				'wallpaper' => 'default_wall.jpg',
			]);
			Album::create([
				'name' => 'My Pic',
				'user_id' => $user->id,
				'privilege' => 0
			]);
			Pending::where('token', $token)->delete();
			return view("auth.login");
		}
		else
			return "wrong token or token is expired";
	}

}
