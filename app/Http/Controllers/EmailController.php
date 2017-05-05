<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 
class EmailController extends Controller
{
    //
	public function send(Request $request){
		Mail::send("testmail", ["title" => "Test", "content" => "Hello"], function($message){
			$message->from("k1@gmail.com", "k1");
			$message->to("congdt1123@gmail.com");
		} );
		if(Mail::failures()){
			return response()->json(['message'=> 'request Fail']);
		}
		return response()->json(['message'=> 'request completed']);
	}
}
