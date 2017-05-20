@extends('layouts.master')
@section('title','Kho ảnh')


@section('content')
<div id="div1" class="col-sm-10 sidenav" style="padding-left: 200px; background-color: white; padding-top: 50px;">
<form action="deleteimage" method="POST">
  <label>Bạn có thực sự muốn xóa ảnh? </label>
  <hr>
  <img src="{{ url('/') . '/storage/' . $picture['filePath'] }}" width="60%" alt="Lỗi load ảnh">
  <input type="hidden" name="picture_id" value="{{ $picture['id'] }}">
  <hr>
  <button class="btn btn-primary">Xóa</button>
</form>
</div>
@endsection
@section('footer')
@endsection