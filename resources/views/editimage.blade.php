@extends('layouts.master')
@section('title','Kho ảnh')


@section('content')
<div id="div1" class="col-sm-10 sidenav" style="padding-left: 200px; background-color: white; padding-top: 50px;">
<form action="/updatePicture" method="POST">
  <div class="form-group col-sm-10" style="padding-left: 0px; font-family: cursive; font-size: 18px">
    <label>Hãy nói gì về ảnh của bạn</label>
    <textarea class="form-control" rows="5" name="description">{{ $picture['description'] }} </textarea>
    <label>Phạm vi</label>
    <select class="form-control col-sm-5" id="sel1" name="privilege">
	  @if( $picture['privilege'] == '0' )
      <option value='0'>Mọi người</option>
      <option value='1'>Chỉ mình tôi</option>
	  @else
	  <option value='1'>Chỉ mình tôi</option>
      <option value='0'>Mọi người</option>
	  @endif
    </select>
  </div>
  <br>
  <img src="{{ url('/') . '/storage/' . $picture['filePath'] }}" width="60%" alt="Lỗi load ảnh">
  <hr>
  <input type="hidden" name="picture_id" value="{{ $picture['id'] }}">
  <input type="submit" value="Xóa">
</form>
</div>
@endsection
@section('footer')
@endsection