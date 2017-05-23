@extends('layouts.master')
@section('title','Trang cá nhân')


@section('content')
<div id="div1" class="col-sm-10 sidenav">
  <div class="profile text-left" >	
	
    <div style="margin-top: 180px;">
      <span class="tieude">
      <img src="{{ Storage::url(Auth::user()->avatar) }}" class="img-circle" alt="Cinque Terre" width="100" height="100"> 
      <span style="font-size: 30px;"> {{ Auth::user()->name }} </span><br/>
      <br>
      </span>
    </div>
  </div>
  <div id="div2" class="col-sm-12 sidenav" style="font-family: cursive; font-size: 20px; padding: 0px; margin: 0px">
    <a href="editprofile" style="padding-left: 35px;"><button class="btn btn-primary">Chỉnh sửa hồ sơ</button></a>
	<a href="editwallpaper" style="padding-left: 35px;"><button class="btn btn-primary">Chỉnh sửa ảnh bìa</button></a>
    <br>
    <div id="div2" class="col-sm-6">
      @for( $i = 0; $i < round(count($pictures)/2); $i++)
      <div class="text-left user">
          <span class="tieude">
              <img src="{{ Storage::url(Auth::user()->avatar) }}"" class="img-circle" alt="Cinque Terre" width="40" height="40"/>
               {{ Auth::user()->name }}
              <br/>
			  <br>
          </span>
		  <p style="font-family: cursive"> {{ $pictures[$i]['description'] }} </p>
          <img src="{{ Storage::url( $pictures[$i]['filePath']) }}" alt="myphoto" style="width:100%"/>  
          <br>
          <br>
          @if( $pictures[$i]['button'] === 'Like' )
			<button id="{{ $pictures[$i]['button'] }}" name="{{ $pictures[$i]['id'] }}" class="btn btn-default" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    <i class="fa fa-heart-o" style="font-size:12px;color:red"></i></button>
			@elseif($pictures[$i]['button'] === 'Liked')
			<button id="{{ $pictures[$i]['button'] }}" name="{{ $pictures[$i]['id'] }}" class="btn btn-danger" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    <i class="fa fa-heart-o" style="font-size:12px;"></i></button>
		  @endif 
         <button id="show_comment" name="{{ $pictures[$i]['id'] }}" style="font-size: 12px"  ><i class="fa fa-comment-o"></i></button>
		    <hr>
          <hr>
          
		  <!-- hien thi comment khi ban nut show_comment  -->
			<div class="media" style="font-family : cursive;">
			  <div class="media-left">
				<img src=" {{ Storage::url(Auth::user()->avatar) }} " class="media-object" style="height:40px;">
			  </div>
			  <div class="media-body">
				<input id="comment_content_{{ $pictures[$i]['id'] }}" type="text" class="form-control" placeholder="Viết bình luận">
				<button id="comment" style="font-size: 12px" onclick="ajax_comment('{{ $pictures[$i]['id'] }}')" > Bình luận </button>
			  </div>
			</div>
			<div id="display_comment_id_{{ $pictures[$i]['id'] }}">
			</div>
			 
			<div id="load_comment_{{ $pictures[$i]['id'] }}">  
			</div>
		   <!-- ket thuc -->
      </div>
      @endfor
    </div>
    <div id="div3" class="col-sm-6">
      @for($i = round(count($pictures)/2); $i < count($pictures); $i++)
      <div class="text-left user">
          <span class="tieude">
              <img src="{{ Storage::url(Auth::user()->avatar) }}"" class="img-circle" alt="Cinque Terre" width="40" height="40"/>
              {{ Auth::user()->name }}
              <br/>
			  <br>
          </span>
		  <p style="font-family: cursive"> {{ $pictures[$i]['description'] }} </p>
          <img src="{{ Storage::url( $pictures[$i]['filePath']) }}" alt="myphoto" style="width:100%"/>  
          <br>
          <br>
          @if( $pictures[$i]['button'] === 'Like' )
			<button id="{{ $pictures[$i]['button'] }}" name="{{ $pictures[$i]['id'] }}" class="btn btn-default" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    <i class="fa fa-heart-o" style="font-size:12px;color:red"></i></button>
			@elseif($pictures[$i]['button'] === 'Liked')
			<button id="{{ $pictures[$i]['button'] }}" name="{{ $pictures[$i]['id'] }}" class="btn btn-danger" style="font-size: 12px">{{$pictures[$i]['numLike'] }} 
		    <i class="fa fa-heart-o" style="font-size:12px;"></i></button>
		  @endif 
         <button id="show_comment" name="{{ $pictures[$i]['id'] }}" style="font-size: 12px"  ><i class="fa fa-comment-o"></i></button>
		   <hr>
          <!-- hien thi comment khi ban nut show_comment  -->
			<div class="media" style="font-family : cursive;">
			  <div class="media-left">
				<img src=" {{ Storage::url( Auth::user()->avatar) }} " class="media-object" style="height:40px;">
			  </div>
			  <div class="media-body">
				<input id="comment_content_{{ $pictures[$i]['id'] }}" type="text" class="form-control" placeholder="Viết bình luận">
				<button id="comment" style="font-size: 12px" onclick="ajax_comment('{{ $pictures[$i]['id'] }}')" > Bình luận </button>
			  </div>
			</div>
			<div id="display_comment_id_{{ $pictures[$i]['id'] }}">
			</div>
			 
			<div id="load_comment_{{ $pictures[$i]['id'] }}">  
			</div>
			<!-- ket thuc -->
      </div>
      @endfor()
    </div>
  </div>
</div>
@endsection
@section('footer')
@endsection