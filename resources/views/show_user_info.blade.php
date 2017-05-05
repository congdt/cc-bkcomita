<!DOCTYPE html>
<html>
<head>
 <title> User Info </title>
</head>

<body>
	<p> ID: {{ $user->_id }} </p>
	<p> Name: {{ $user->name }} </p>
	<p> Phone: {{ $user->phone }} </p>
	<p> Address: {{ $user->address }} </p>
	
</body>
</html>