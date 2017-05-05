<html>
<head>
</head>

<body>
	<div style="border-radius: 5px; border-style: solid; ">
            @foreach( $errors->all() as $error )
               <br> {{ $error }}
            @endforeach
        </div>
	<h1> {{ $user->name }} </h1>
	<form action="logout" method="post">
		<input type="submit" value="logout">
	</form>
	<h2> <a href="uploadForm"> UpPic </a>  <br> </h2>
	Chinh sua thong tin ca nhan <a href="#"> tai day </a> <br>
	<h2> Album </h2>
	@foreach( $albums as $album )
	<a href=# > {{ $album->name }} </a><br>
	@endforeach
	
	<h2> Kho anh chung <h2>
	@foreach ($pictures as $picture)
		<div style="border-radius: 10px; border-style: solid; ">
		<form action="updatePicture" method="post">
			<select name="privilege">
				<option value="0"> Public </option>
				<option value="1"> Private </option> 
			</select>
			<p><a href="/{{ $user->id . '/' . $picture['album_id'] }}"> {{ $picture['album_name'] }} </a></p>
			<input style="font-size:16; font-style:bold" type="text" name="description" value="{{ $picture['description'] }}"><br><br>
			<input type="text" name="picture_id" value="{{ $picture['id'] }}" hidden>
			<img src="{{ Storage::url($picture['filePath']) }}"  style="height:300; width: auto" ><br>
			<h3> Like: {{ $picture['numLike'] }}
			<h3> {{ $picture['created_at'] }} </h3>
			<select name="operation">
				<option value="update"> Update</option>
				<option value="delete"> Delete</option> 
			</select>
			<input type="submit" value="Do Operation" >
		</form>
		</div>
	@endforeach 
	
</body>
</html>