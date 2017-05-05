
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
	@if (Auth::check())
    <script language="javascript">
        function load_ajax( picture_id){
            $.ajax({
                url : "/like",
                type : "post",
                dataType:"json",
                data : {
					'picture_id' : picture_id
                },
                success : function (result){
					console.log(result);
					//var data = $.parseJSON(result);
					
					if(result.title === 'success'){
						$('#numLike').html(result.numLike);
						$('#like_button_' + picture_id).attr("value", result.button);
						console.log(result.numLike);
					}
					else 
						alert("fail");
					
                },
				error : function (data){
					alert("fail");
				}
            });
        
        }
    </script>
	@endif
</head>

<body>
	@if (Auth::check())
	<form action="/logout" method="post">
		<input type="submit" name="logout" value="logout">
	</form>
	<h1> {{ Auth::user()->name }} </h1>
	@else
	<div style="border-style:solid; border-radius:5">
		<a href="/login"> Login </a> || 
		<a href="/register"> Register </a>
	</div>
	<h1> Guest </h1>
	@endif
	<div>
		<h1> Picer: {{ $user->name }} </h1>
	</div>
	@foreach ($pictures as $picture)
	<div style="border-radius: 10px; border-style: solid; ">
		<p>{{ $picture['description'] }} </p>
		<img src="{{ Storage::url($picture['filePath']) }}" style="height:300; width: auto" ><br>
		<a href="{{ $picture['user_id'] }}"> {{ $picture['user_name']}}</a><br>
		Album: <a href="{{ $picture['user_id'] . '/' . $picture['album_id']}}"> {{ $picture['album_name'] }} </a><br>
		
		@if (Auth::check())
		<input type="submit" value="{{ $picture['button'] }}" name="like" onclick="load_ajax('{{ $picture['id'] }}')"> <p id="like">{{ $picture['numLike'] }} </p>
		@else 
			<p> Like: {{ $picture['numLike'] }} </p>
		@endif
	</div>
	@endforeach
</body>
</html>
