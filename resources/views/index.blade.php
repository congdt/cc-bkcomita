@extends('layouts.master')
@section('title','Trang chủ')

@section('content')
@parent
	@section('name1')
		@for($i = 0; $i < count($pictures)/2; $i++)
		<div class="text-left user">
		    <span class="tieude">
		        
				{{$pictures[$i]['user_name'] }}
		        <br/>
		        <br>
		    </span>
		    <img src="{{ Storage::url($pictures[$i]['filePath']) }}" alt="myphoto" style="width:100%"/>  
		    <br>
		    <br>
		    <button id="like" class="btn btn-default" style="font-size: 12px">{{$pictures[$i]['numLike']}} 
		    	<i class="fa fa-heart-o" style="font-size:12px;color:red"></i></button>
		    <button id="comment" style="font-size: 12px"><i class="fa fa-comment-o"></i></button>
		    <hr>
		    <div id="content_cmt"></div>
		</div>
		@endfor
	@endsection
	@section('name2')
		@for($i = count($pictures)/2; $i < count($pictures); $i++)
		<div class="text-left user">
		    <span class="tieude">
		        
				{{$pictures[$i]['user_name']}}
		        <br/>
		        <br>
		    </span>
		    <img src="{{ Storage::url($pictures[$i]['filePath']) }}" alt="myphoto" style="width:100%"/>  
		    <br>
		    <br>
		    <button id="like" class="btn btn-default" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    	<i class="fa fa-heart-o" style="font-size:12px;color:red"></i></button>
		    <button id="comment" style="font-size: 12px"><i class="fa fa-comment-o"></i></button>
		    <hr>
		    <div id="content_cmt"></div>
		</div>
		@endfor
	@endsection
@endsection
@section('footer')