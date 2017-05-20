@extends('layouts.master')
@section('title','Chỉnh sửa hồ sơ')


@section('content')
<style type="text/css">
  table {
    
  }
  td {
	
    padding: 10px;
	width: 270px;
    height: 270px;
    //display: inline-block;
    //overflow: auto;
  }
  #avatar{
    padding-left: 100px;
    background-color: white;
    padding-top: 50px;
  }
</style>
<div id="avatar" class="col-sm-9 sidenav">
  <form action="/editprofile" method="post">
    <label>Tên người dùng:</label>
    <input type="text" class="form-control" id="usr" name="user_name" value="{{ $user->name }}"> <br>
    <label for="usr">Chọn ảnh đại diện:</label>
    <table border="1">
	  <tr>
		<input type="radio" value="{{ $user->avatar }}" name="picture_id" checked>
		
	  </tr>
	@for ($i = 0; $i < count($pictures) ; $i += 3 )
	  
      <tr>
        <td>
          <input type="radio" value="{{ $pictures[$i]->id }}" name="picture_id">
          <img src="{{ url('/') . '/storage/' . $pictures[$i]->filePath }}" style="display: block" width="100%" >
        </td>
		@if($i+1 < count($pictures))
        <td>
          <input type="radio" value="{{ $pictures[$i+1]->id }}" name="picture_id">
          <img src="{{ url('/') . '/storage/' . $pictures[$i+1]->filePath }}" style="display: block" width="100%">
        </td>
		@endif
		@if($i+2 < count($pictures))
        <td>
          <input type="radio" value="{{ $pictures[$i+2]->id }}" name="picture_id">
          <img src="{{ url('/') . '/storage/' . $pictures[$i+2]->filePath }}" style="display: block" width="100%">
        </td>
		@endif
      </tr>
		
	@endfor
      
    </table>
	<br>
    <input type="submit" class="btn btn-danger" name="update" value="Cập nhật">
  </form>
  <br>
</div>
@endsection