<!DOCTYPE html>

<html>

<head>
	<title> Sign In </title>
</head>
<body>

	<form action="" method="post">
		@if( isset($error) )
			<p> {{$error}} </p>
		@endif 
		<h2> Username: <input type="text" name="name" size="50"> </h2>
		<h2> Password: <input type="password" name="password" size="50"> </h2>
		<input type="submit" value="Sign In">
	</form>
</body>

</html>