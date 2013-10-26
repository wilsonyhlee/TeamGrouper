<html>
<head>
	<title>Pledg Admin Panel</title>
</head>
<body>
	<h1>Pledg Admin Panel</h1>
	<a href="<?php echo URL::to('admin/logout'); ?>">Logout</a>
	<?php if(isset($msg)) { echo $msg; } ?>
	<h2>Transaction Log</h2>
	<table>
		<th>Date/Time</th><th>Merchant</th><th>Customer</th><th>Charity</th><th>Amount</th><th>Charge ID</th>
		<?php foreach($charges as $charge) : ?>
		<tr>
			<td><?php echo $charge->datetime ?></td>
			<td><?php echo $charge->merchant ?></td>
			<td><?php echo $charge->first_name.' '.$charge->last_name ?></td>
			<td><?php echo $charge->charity ?></td>
			<td><?php echo $charge->amount ?></td>
			<td><?php echo $charge->charge_id ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<h2>Merchant Accounts</h2>
	<div>
		<a href="<?php echo URL::to('admin/add_merchant') ?>">Add New Merchant</a>
	</div>
	<table>
		<th>Merchant</th><th>Email</th><th>Street Address</th><th>Edit</th><!-- <th>Delete</th> -->
		<?php foreach($merchants as $merchant) : ?>
		<tr>
			<td><?php echo $merchant->merchant ?></td>
			<td><?php echo $merchant->email ?></td>
			<td><?php echo $merchant->street_address ?></td>
			<td><a href="<?php echo URL::to('admin/edit_merchant') ?>?id=<?php echo $merchant->merchant_id ?>">Edit</a></td>
			<!-- <td><a href="<?php echo URL::to('admin/delete_merchant') ?>">Delete</a></td> -->
		</tr>
		<?php endforeach ?>
	</table>
</body>
</html>