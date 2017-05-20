@extends('layouts.master')
@section('title','Kho ảnh')


@section('content')
<div id="div1" class="col-sm-10 sidenav" style="padding-left: 200px; background-color: white;">
  @for($i = 0; $i < count($pictures); $i++)
  <div class="btn-group" style="padding-top: 30px; padding-left: 0px;">
  <p style="font-family: cursive; font-size: 18px">{{ $pictures[$i]['description'] }}</p>
    <span><button type="button" data-toggle="dropdown" style="border: hidden; background-color: #f1f1f1;">
    <span class="caret"></span></button><span></span>
    <ul class="dropdown-menu" role="menu">
      <li><a href="editimage?picture_id={{ $pictures[$i]['id'] }}"><button class="btn btn-block btn-default" style="border: hidden; text-align: left;">Chỉnh sửa</button></a></li>
      <li><a href="deleteimage?picture_id={{ $pictures[$i]['id'] }}"><button class="btn btn-block btn-default" style="border: hidden; text-align: left;">Xóa</button></a></li>
    </ul>
  </div>
  <br>
  <img src="{{ url('/') . '/storage/' . $pictures[$i]['filePath'] }}" width="60%" alt="Lỗi load ảnh">
  <br>
  <hr>
  @endfor
  <hr>
</div>
@endsection
@section('footer')
@endsection