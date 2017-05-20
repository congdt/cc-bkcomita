@extends('layouts.master')
@section('title','Chỉnh sửa ảnh bìa')


@section('content')
<style type="text/css">
  table {
    
  }
  td {
	
    padding: 10px;
	width: 300px;
    height: 250px;
    //display: inline-block;
    //overflow: auto;
  }
  #wallpaper{
    //padding-left: 100px;
    background-color: white;
    padding-top: 50px;
  }
</style>
	  

<div id="wallpaper" class="col-sm-10 sidenav">
  <div style="height: 300px;
	  width : 1040px;
	  background: url({{url('/') . '/storage/' . Auth::user()->wallpaper }}) no-repeat; 
	  background-size: 1040px 300px;
      padding: 1px;
	  
      " >	
	
    <div style="margin-top: 180px;">
      <span class="tieude">
      <img src="{{ url('/') . '/storage/' . Auth::user()->avatar }}" class="img-circle" alt="Cinque Terre" width="100" height="100"> 
      <span style="font-size: 30px;"> {{ Auth::user()->name }} </span><br/>
      <br>
      </span>
    </div>
  </div>
  
  
  <form action="/editwallpaper" method="post">
    
	@if ($errors->has('picture_id'))
		{{ $errors->first('picture_id') }}
		{{ "Không có ảnh nào được chọn" }}
	@endif
	
    <label for="usr"><h3>Chọn ảnh bìa: </h3></label>
    <table  align="center">
	  <tr>
		<input type="radio" value="{{ $user->wallpaper }}" name="picture_id" checked>
		
	  </tr>
	@for ($i = 0; $i < count($pictures) ; $i += 3 )
	  
      <tr>
        <td>
          <input type="radio" value="{{ $pictures[$i]->id }}" name="picture_id">
		  
          <img src="{{ url('/') . '/storage/' . $pictures[$i]->filePath }}" style="display: block;" width="100%"  >
        </td>
		@if($i+1 < count($pictures))
        <td>
          <input type="radio" value="{{ $pictures[$i+1]->id }}" name="picture_id">
          <img src="{{ url('/') . '/storage/' . $pictures[$i+1]->filePath }}" style="display: block" width="100%" >
        </td>
		@endif
		@if($i+2 < count($pictures))
        <td>
          <input type="radio" value="{{ $pictures[$i+2]->id }}" name="picture_id">
          <img src="{{ url('/') . '/storage/' . $pictures[$i+2]->filePath }}" style="display: block" width="100%" >
        </td>
		@endif
      </tr>
		
	@endfor
      
    </table>
	<br>
	<div style="text-align: center;">
    <input  type="submit" class="btn btn-danger" name="update" value="Lưu thay đổi">
	</div>
  </form>
  <br>
</div>


@endsection