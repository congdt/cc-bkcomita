<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ url('/') . '/storage/css/bootstrap.min.css' }}">
  <link rel="stylesheet" href="{{ url('/') . '/storage/css/w3.css' }}">
  <link rel="stylesheet" href="{{ url('/') . '/storage/css/font-awesome.min.css' }}">
  <script src="{{ url('/') . '/storage/js/jquery.min.js' }}"></script>
  <script src="{{ url('/') . '/storage/js/bootstrap.min.js' }}"></script>
  <script src="{{ url('/') . '/storage/js/index.js' }}" type="text/javascript"></script>
  <title>@yield('title')</title>
  <style>
    /*CSS cho phần tiêu đề */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      box-shadow: 5px 5px 5px #666;
      padding-left: 400px;
      display: inline;
    }
    /*CSS cho phần cột bên trái col-2 */
    .sidenav {
      padding-top: 0px;
      text-align: left;
      margin-top: 10px;
      overflow: hidden;
    }
    .col-2 {
      width: 250px;
    }
    #button_left{
      padding: 20px;
    }
    .banquyen {
      width: 200px;
      height: 200px;
      padding-top: 100px;
      padding-bottom: 100px;
      font-size: 12px;
      font-family: cursive;
      color: rgb(128,128,128)
    }

    /*CSS phần nội dung hiển thị ảnh */
    /* Nội dung chung */
    .row.content {
      padding-top: 50px;
      background-color: #f1f1f1;
    }
    
    /* CSS cho mỗi phần hiển thị ảnh của 1 người */
    .user {
      background-color: white;
      padding: 10px;
      margin: 20px;
    }
    /* CSS cho avatar */
    .tieude {
      font-weight: bold;
      padding-left: 0px;
    }
	
    .profile {
      height: 300px;
	  width : 1040px;
    @if (Auth::check())
	  background: url({{url('/') . '/storage/' . Auth::user()->wallpaper }}) no-repeat; 
	  background-size: cover;
	  background-position: center center;
	@endif
      padding: 1px;
      margin: 30px;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #f1f1f1;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }

  </style>
</head>
<body>
<nav id="nav" class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li id="trangchu"><a href="/index">Trang chủ</a></li>
      @yield('profile')
	  @if (Auth::check())
      <li id="trangcanhan"><a href="/profile"><img src="{{ url('/') . '/storage/' . Auth::user()->avatar }}" class="img-circle" alt="Cinque Terre" width="25" height="25"/> {{ Auth::user()->name }}</a></li>
	  @endif 
    </ul>
    <form class="navbar-form navbar-left">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Tìm kiếm">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
    <ul id="login" class="nav navbar-nav navbar-right">
	@if(!Auth::check())
      <li><a href="/register"><span class="glyphicon glyphicon-user"></span> Đăng kí</a></li>
      <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Đăng nhập</a></li>
	@else
	  <li><a href="/logout"><span class="glyphicon glyphicon-log-in"></span> Đăng xuất</a></li>
	@endif
    </ul>
  </div>
</nav> 
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <div class="container col-2" data-spy="affix">
        <ul class="nav nav-pills nav-stacked">
          <li id="danganh">
            <a href="/uploadForm"><i class="fa fa-camera" style="font-size:20px"></i> <span id="button_left"> Đăng ảnh </span></a>
          </li>
          <li id="khoanh">
            <a href="/editalbum"><i class="fa fa-image" style="font-size:20px"></i> <span id="button_left"> Kho ảnh</span></a>
          </li>
          <li id="theodoi">
            <a href="#"><i class="fa fa-user-secret" style="font-size:20px"></i> <span id="button_left"> Theo dõi</span></a>
          </li>
        </ul>
        <div class="banquyen">
          <p>Trang web được phát triển bởi nhóm sinh viên An toàn thông tin K58 - Đại học Bách Khoa Hà Nội</p>
          <p><i style="font-size:20px" class="fa">&#xf1f9;</i> 2017 Comita team- HUST </p>
          <p>Web XXX</p>
        </div>
      </div>
    </div>
    @section('content')
    <div id="div1" class="col-sm-5 sidenav">
      @yield('name1')
    </div>
    <div id="div2" class="col-sm-5 sidenav">
      @yield('name2')
    </div>
    @show
  </div>
</div>
@section('footer')
<footer class="container-fluid text-center">
  <div class="container">
    <!--<button id="taithem" type="button" class="btn btn-primary btn-block">Tải thêm</button>  -->
  </div>
</footer>
@show
</body>
</html>
