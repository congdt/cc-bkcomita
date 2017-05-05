<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
	
</head>

<body>
	@if (Auth::check())
    <script language="javascript">
        function like_ajax( picture_id){
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
						$('#numLike_' + picture_id).html(result.numLike);
						$('#like_button_' + picture_id).attr("value", result.button);
						console.log(result.numLike);
					}
					else 
						alert(result.title);
					
                },
				error : function (data){
					alert("fail");
				}
            });
        
        }
		function comment_ajax( picture_id){
			console.log('comment_content_' + picture_id);
			var comment_content = document.getElementById('comment_content_' + picture_id).value;
			
			$.ajax({
				url : "/comment",
				type : "post",
				dataType: "json",
				data : {
					'picture_id' : picture_id,
					'comment_content' : comment_content
				},
				success : function (result){
					if(result.title === 'success'){
						var comment_div = document.createElement('div');
						var user_link = document.createElement('a');
						var content = document.createElement('p');
						
						user_link.setAttribute('href', "/user/"+ result.user_id);
						user_link.innerHTML = result.user_name;
						content.innerHTML = result.comment_content + " || created_at: " + result.created_at;
						
						comment_div.appendChild(user_link);
						comment_div.appendChild(content);
						
						
						//var comment_tag = "<a href='/user/" + result.user_id + "'> " + result.user_name +  " </a> ";
						//comment_tag += result.content_comment + result.created_at;
						//('#display_comment_id_' + result.picture_id.toString()).appendChild(comment_div);
						var display_comment = document.getElementById('display_comment_id_' + result.picture_id);
						display_comment.appendChild(comment_div);
					}
					else {
						alert(result.title);
					}
				},
				error : function (data){
					alert("comment error");
				}
			});
		}
		
    </script>
	@endif
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
	@foreach ($pictures as $picture)
	<div style="border-radius: 10px; border-style: solid; ">
		<p>{{ $picture['description'] }} </p>
		<img src="{{ Storage::url($picture['filePath']) }}" style="height:300; width: auto" ><br>
		<a href="{{ 'user/'.$picture['user_id'] }}"> {{ $picture['user_name']}}</a><br>
		Album: <a href="{{ 'user/'. $picture['user_id'] . '/' . $picture['album_id']}}"> {{ $picture['album_name'] }} </a><br>
		@if (Auth::check())
		<div id="like">
		<input id="like_button_{{ $picture['id'] }}" type="submit" value="{{ $picture['button'] }}" name="like" onclick="like_ajax('{{ $picture['id'] }}')"> <p id="numLike_{{ $picture['id'] }}">{{ $picture['numLike'] }} </p>
		</div>
		<div>
			<h3>
			{{ Auth::user()->name }} 
			<input type="text" id="comment_content_{{ $picture['id'] }}" size="100"> 
			<input type="submit" name="comment_button" value="Comment" onclick="comment_ajax({{ $picture['id'] }}) "><br>
			</h3>
		</div>
		<div id="display_comment_id_{{ $picture['id'] }}">
			
		</div>
		
		@else 
			<p> Like: {{ $picture['numLike'] }} </p>
		@endif
		<div>
		@for ($i = 0; $i < count($picture['comment']); $i++)
			<a href="/user/{{ $picture['users_comment'][$i]->user_comment_id }}"> {{ $picture['users_comment'][$i]->user_comment_name }} </a>
			<p> {{ $picture['comment'][$i]->content }} <br> {{ $picture['comment'][$i]->created_at }} </p>
		@endfor
		</div>
		
	</div>
	
	@endforeach
	
	
</body>
</html>