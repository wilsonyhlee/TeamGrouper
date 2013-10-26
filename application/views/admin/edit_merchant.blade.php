<html>
<head>
	<title>Pledg Admin Panel - Add Merchant</title>
</head>
<body>
	<h1>Pledg Admin Panel - Add Merchant</h1>
	<form action="<?php echo URL::to('admin/edited') ?>" method="post">
		<input type='hidden' name='merchant_ID' value='<?php echo $merchant->merchant_id ?>' />
		<label>Merchant Name:</label><input type='text' name='merchant' value='<?php echo $merchant->merchant ?>' /><br>
		<label>Email:</label><input type='text' name='email' value='<?php echo $merchant->email ?>' /><br>
		<label>Street Address 1:</label><input type='text' name='street_address' value='<?php echo $merchant->street_address ?>' /><br>
		<label>Street Address 2:</label><input type='text' name='street_address2' value='<?php echo $merchant->street_address2 ?>' /><br>
		<label>City:</label><select name='city_ID'>
			<option value='<?php echo $merchant->city_id ?>'><?php echo $merchant->city ?></option>
			<?php foreach($cities as $city) : ?>
			<option value='<?php echo $city->city_id ?>'><?php echo $city->city ?></option>
			<?php endforeach ?>
		</select><br>
		<label>Zip Code:</label><input type='text' name='zip' value='<?php echo $merchant->zip ?>' /><br>
		<label>Phone:</label><input type='text' name='phone' value='<?php echo $merchant->phone ?>' /><br>
		<label>URL:</label><input type='text' name='url' value='<?php echo $merchant->url ?>' /><br>
		<label>Logo Link:</label><input type='text' name='logo' value='<?php echo $merchant->logo ?>' /><br>
         <label>Password:</label><input type='password' name='password' /><br>
		<input type="submit" value="Update Merchant" />
	</form>
</body>
</html>