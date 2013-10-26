<html>
<head>
	<title>Admin Panel Login</title>
</head>
<body>
	<h1>Admin Panel Login</h1>
	<form action="<?php echo URL::to('admin/admin'); ?>" method="post">
		<label>Username:</label><input type="text" name="username" /><br>
		<label>Password:</label><input type="text" name="password" /><br>
		<input type="submit" value="Submit">
	</form>

</body>
</html>