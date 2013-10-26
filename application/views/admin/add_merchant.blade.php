<html>
<head>
	<title>Pledg Admin Panel - Add Merchant</title>
</head>
<body>
	<h1>Pledg Admin Panel - Add Merchant</h1>
	<form action="<?php echo URL::to('admin/added') ?>" method="post">
		<label>Merchant Name:</label><input type='text' name='merchant' /><br>
		<label>Email:</label><input type='text' name='email' /><br>
		<label>Street Address 1:</label><input type='text' name='street_address' /><br>
		<label>Street Address 2:</label><input type='text' name='street_address2' /><br>
		<label>City:</label><select name='city_ID'>
			<option></option>
			<?php foreach($cities as $city) : ?>
			<option value='<?php echo $city->city_id ?>'><?php echo $city->city ?></option>
			<?php endforeach ?>
		</select><br>
		<label>Zip Code:</label><input type='text' name='zip' /><br>
		<label>Phone:</label><input type='text' name='phone' /><br>
		<label>URL:</label><input type='text' name='url' /><br>
		<label>Logo Link:</label><input type='text' name='logo' /><br>
        <label>Password:</label><input type='password' name='password' /><br>
		<input type="submit" value="Add New Merchant" />
	</form>
</body>
</html>