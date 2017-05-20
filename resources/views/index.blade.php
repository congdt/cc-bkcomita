@extends('layouts.master')
@section('title','Trang chủ')

@section('content')
@parent
	@section('name1')
		@for($i = 0; $i < round(count($pictures)/2); $i++)
		<div class="text-left user">
		    <span class="tieude">
		        <a href="{{ url('/') . '/user/' . $pictures[$i]['user_id'] }}">
					<img src="{{ url('/') . '/storage/' . $pictures[$i]['user_avatar'] }}" class="img-circle" alt="Cinque Terre" width="40" height="40"/>
					{{$pictures[$i]['user_name'] }} 
				</a>
		        
		        <br>
		    </span>
			<br>
			<p style="font-family: cursive"> {{ $pictures[$i]['description'] }} </p>
		    <img src="{{ url('/') . '/storage/' . $pictures[$i]['filePath'] }}" alt="myphoto" style="width:100%"/>  
		    <br>
		    <br>
		    @if (Auth::check())
				@if ($pictures[$i]['button'] === 'Like' )
				<button id="{{ $pictures[$i]['button'] }}" name="{{ $pictures[$i]['id'] }}" class="btn btn-default" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    	<i class="fa fa-heart-o" style="font-size:12px;color:red"></i></button>
				@elseif ($pictures[$i]['button'] === 'Liked')
				<button id="{{ $pictures[$i]['button'] }}" name="{{ $pictures[$i]['id'] }}" class="btn btn-danger" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    	<i class="fa fa-heart-o" style="font-size:12px;"></i></button>
				@endif 
			@else 
			<button id="label" name="{{ $pictures[$i]['id'] }}" class="btn btn-default" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    </button>
			
			@endif 
		    <button id="show_comment" name="{{ $pictures[$i]['id'] }}" style="font-size: 12px" ><i class="fa fa-comment-o"></i></button>
		    <hr>
		    @if(Auth::check())
			<div class="media" style="font-family : cursive;">
			  <div class="media-left">
				<img src=" {{ url('/') . '/storage/' . Auth::user()->avatar }} " class="media-object" style="height:40px;">
			  </div>
			  <div class="media-body">
				<input id="comment_content_{{ $pictures[$i]['id'] }}" type="text" class="form-control" placeholder="Viết bình luận">
				<button id="comment" style="font-size: 12px"  onclick="ajax_comment('{{ $pictures[$i]['id'] }}')"> Bình luận </button>
			  </div>
			</div>
			<div id="display_comment_id_{{ $pictures[$i]['id'] }}">
			</div>
			 @endif
			<div id="load_comment_{{ $pictures[$i]['id'] }}">  
			@for( $j = 0; ($j < count($pictures[$i]['comments']) && $j < 2); $j++)
				<div class="media" style="font-family: cursive;">
					<div class="media-left">
						<img class="media-object" style="width:60px; height:40px;" src="{{ url('/') . '/storage/' . $pictures[$i]['users_comment'][$j]->user_comment_avatar }}" >
						
					</div>
					<div class="media-body">
						<h5 class="media-heading">{{ $pictures[$i]['users_comment'][$j]->user_comment_name }} </h5>
						<p style="font-size: 16px;">{{ $pictures[$i]['comments'][$j]->content }}</p>
					</div>
				</div>
			@endfor

			</div>
		</div>
		@endfor
	@endsection
	@section('name2')
		@for($i = round(count($pictures)/2); $i < count($pictures); $i++)
		<div class="text-left user">
		    <span class="tieude">
		        <a href="{{ url('/') . '/user/' . $pictures[$i]['user_id'] }}">
					<img src="{{ url('/') . '/storage/' . $pictures[$i]['user_avatar'] }}" class="img-circle" alt="Cinque Terre" width="40" height="40"/>
					{{$pictures[$i]['user_name'] }} 
				</a>
		        <br>
		    </span>
			<br>
			<p style="font-family: cursive"> {{ $pictures[$i]['description'] }} </p>
		    <img src="{{ url('/') . '/storage/' . $pictures[$i]['filePath'] }}" alt="myphoto" style="width:100%"/>  
		    <br>
		    <br>
			@if (Auth::check())
				@if( $pictures[$i]['button'] === 'Like' )
				<button id="{{ $pictures[$i]['button'] }}" name="{{ $pictures[$i]['id'] }}" class="btn btn-default" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    	<i class="fa fa-heart-o" style="font-size:12px;color:red"></i></button>
				@elseif($pictures[$i]['button'] === 'Liked')
				<button id="{{ $pictures[$i]['button'] }}" name="{{ $pictures[$i]['id'] }}" class="btn btn-danger" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    	<i class="fa fa-heart-o" style="font-size:12px;"></i></button>
				@endif 
			@else 
			<button id="label" name="{{ $pictures[$i]['id'] }}" class="btn btn-default" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    </button>
			
			@endif 
		    <button id="show_comment" name="{{ $pictures[$i]['id'] }}" style="font-size: 12px"  ><i class="fa fa-comment-o"></i></button>
		    <hr>
		    
			@if(Auth::check())
			<div class="media" style="font-family : cursive;">
			  <div class="media-left">
				<img src=" {{ url('/') . '/storage/' . Auth::user()->avatar }} " class="media-object" style="height:40px;">
			  </div>
			  <div class="media-body">
				<input id="comment_content_{{ $pictures[$i]['id'] }}" type="text" class="form-control" placeholder="Viết bình luận">
				<button id="comment" style="font-size: 12px" onclick="ajax_comment('{{ $pictures[$i]['id'] }}')" > Bình luận </button>
			  </div>
			</div>
			<div id="display_comment_id_{{ $pictures[$i]['id'] }}">
			</div>
			 @endif
			<div id="load_comment_{{ $pictures[$i]['id'] }}">  
			@for( $j = 0; ($j < count($pictures[$i]['comments']) && $j < 2); $j++)
				<div class="media" style="font-family: cursive;">
					<div class="media-left">
						<img class="media-object" style="width:60px; height:40px;" src="{{ url('/') . '/storage/' . $pictures[$i]['users_comment'][$j]->user_comment_avatar }}" >
						
					</div>
					<div class="media-body">
						<h5 class="media-heading">{{ $pictures[$i]['users_comment'][$j]->user_comment_name }} </h5>
						<p style="font-size: 16px;">{{ $pictures[$i]['comments'][$j]->content }}</p>
					</div>
				</div>
			@endfor

			</div>
		</div>
		@endfor
	@endsection
@endsection
@section('footer')