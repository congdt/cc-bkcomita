<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</head>
<body>
    <h1 class="well well-lg">Upload Image</h1>
    <div class="container">
    @if(isset($success))
        <div class="alert alert-success"> {{$success}} </div>
    @endif
		<!--
        {!! Form::open(['action'=>'PictureController@store', 'files'=>true]) !!}

        <div class="form-group">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description:') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control', 'rows'=>5] ) !!}
        </div>

        <div class="form-group">
            {!! Form::label('image', 'Choose an image') !!}
            {!! Form::file('image') !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Save', array( 'class'=>'btn btn-danger form-control' )) !!}
        </div>

        {!! Form::close() !!}
		-->
		<form action="uploadForm" method="post" enctype="multipart/form-data">
			<h3> Description </h3> 
			<input type="text" name="description" size="100"> <br>
			<h3> Privilege </h3> 
			<select name="privilege">
				<option value="0"> Public </option>
				<option value="1"> Private </option>
			</select> <br>
			<h3> Album </h3>
		@if ( isset($albums) )
			@foreach ( $albums as $album )
			
			@if( $albums->first() == $album )
			<input type="radio" name="album_id" value="{{ $album->id }}"  checked> {{ $album->name }} <br>
			@else
			<input type="radio" name="album_id" value="{{ $album->id }}" > {{ $album->name }} <br>
			@endif
			
			@endforeach
		@endif
			<input type="file" name="image" id="image">
			<input type="submit" value="Upload">
		</form>
        <div class="alert-warning">
            @foreach( $errors->all() as $error )
               <br> {{ $error }}
            @endforeach
        </div>
    </div>
</body>
</html>
