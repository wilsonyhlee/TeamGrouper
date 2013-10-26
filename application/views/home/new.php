<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php echo URL::to_asset('css/styles.css');?>">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://js.stripe.com/v1/"></script>
	<script>
		Stripe.setPublishableKey('pk_test_3C8hvFCrpNDcD5JEzatOcsdY');
	</script>
</head>
   
<body>
	<h3>Register</h3>
	<form method="post" id="createForm">
		<label>First Name:</label> 
		<input type="text" name="first_name"> <br>
		<label>Last Name:</label>
		<input type="text" name="last_name"> <br>
		<label>Email:</label>
		<input type="text" name="email"> <br>
		<label>Password:</label>
		<input type="password" name="password"> <br>
		<label>PIN:</label>
		<input type="password" name="pin"> <br>
		<input type="submit">
	</form>
	
	<h3>Log In</h3>
	<form method="post" id="loginForm">
		<label>Email:</label>
		<input type="text" name="email"> <br>
		<label>Password:</label>
		<input type="password" name="password"> <br>
		<input type="submit">
	</form>
	
	<h3>Update</h3>
	<input type="button" id="updateBtn" value="Retrieve Info">
	<form method="post" id="updateForm">
		<label>First Name:</label> 
		<input type="text" name="first_name"> <br>
		<label>Last Name:</label>
		<input type="text" name="last_name"> <br>
		<label>Email:</label>
		<input type="text" name="email"> <br>
		<label>Password:</label>
		<input type="password" name="password"> <br>
		<label>PIN:</label>
		<input type="password" name="pin"> <br>
		<input type="submit">
	</form>
	
	<h3>Add Payment</h3>
	<form method="post" id="addPayment">
		<input type="hidden" name="id">
		<label>Credit Card:</label>
        <input type="text" name="number" autocomplete="off"> <br>
		<label>CVC:</label>
        <input type="text" name="cvc" autocomplete="off"> <br>
        <label>Exp Date:</label>
        <select name="exp-month">
			<option value="1">January</option>
			<option value="2">February</option>
			<option value="3">March</option>
			<option value="4">April</option>
			<option value="5">May</option>
			<option value="6">June</option>
			<option value="7">July</option>
			<option value="8">August</option>
			<option value="9">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
        </select>
		<select name="exp-year">
            <option value="2013">2013</option>
			<option value="2014">2014</option>
			<option value="2015">2015</option>
			<option value="2016">2016</option>
			<option value="2016">2017</option>
			<option value="2016">2018</option>
         </select>
		 <input type="submit">
	</form>
	
	<h3>Create Charge</h3>
	<input type="button" id="getCards" value="Get Card">
	<form method="post" id="createCharge">
		<input type="hidden" name="id">
		<label>Payment:</label>
		<select name="card" id="cards"></select> <br>
		<label>Amount:</label>
		<input type="text" name="amount"> <br>
		<label>Charity:</label>
		<select name="charity" id="charity"></select> <br>
		<input type="submit">
	</form>
	
<script>
(function($) {
	localStorage.clear();
	
	$('#createForm').submit(function(e) {
		e.preventDefault();

		$.ajax({
			url: "http://460test1.usc.edu/pledg/public/pledg/register_customer",
			type: "POST",
			dataType: 'json',
			data: $('#createForm').serialize()
		}).done(function(data) {
			alert(data.msg);
		});
	});
	
	$('#loginForm').submit(function(e) {
		e.preventDefault();

		$.ajax({
			url: "http://460test1.usc.edu/pledg/public/pledg/login_customer",
			type: "POST",
			dataType: 'json',
			data: $('#loginForm').serialize()
		}).done(function(data) {
			alert(data.id);
			localStorage.id = data.id;
		});
	});
	
	$('#updateBtn').on('click',function() {
		$.ajax({
			url: "http://460test1.usc.edu/pledg/public/pledg/retrieve_customer",
			type: "GET",
			dataType: 'json',
			data: {
				id: localStorage.id
			}
		}).done(function(data) {
			console.log(data);
			$('#updateForm').find('input')
				.eq(0).val(data[0].first_name).end()
				.eq(1).val(data[0].last_name).end()
				.eq(2).val(data[0].email).end()
				.eq(3).val(data[0].password).end()
				.eq(4).val(data[0].pin);
		});
	});
	
	$('#addPayment').submit(function(e) {
		e.preventDefault();
		
		$(this).find('input[type="hidden"]').eq(0).val(localStorage.id);

		$.ajax({
			url: "http://460test1.usc.edu/pledg/public/pledg/add_payment",
			type: "POST",
			dataType: 'json',
			data: $('#addPayment').serialize()
		}).done(function(data) {
			console.log(data);
		});
	});
	
	$('#getCards').on('click',function() {
		$.ajax({
			url: "http://460test1.usc.edu/pledg/public/pledg/get_cards",
			type: "GET",
			dataType: 'json',
			data: {
				id: localStorage.id
			}
		}).done(function(data) {
			$('#cards').append(
				'<option value="' + data.id + '">' + data.type + " ending in " + data.last4 + '</option>'
			);
		});
		
		$.ajax({
			url: "http://460test1.usc.edu/pledg/public/pledg/all_charities",
			type: "GET",
			dataType: 'json',
		}).done(function(data) {
			var html = '';

			for (i=0; i<data.length; i=i+1) {
				html = html + '<option value="' + data[i].name + '">' + data[i].name + '</option>';
			}
			
			$('#charity').append(html);
		});
	});
	
	$('#createCharge').submit(function(e) {
		e.preventDefault();
		
		$(this).find('input[type="hidden"]').eq(0).val(localStorage.id);

		$.ajax({
			url: "http://460test1.usc.edu/pledg/public/pledg/charge",
			type: "POST",
			dataType: 'json',
			data: $('#createCharge').serialize()
		}).done(function(data) {
			console.log(data);
			alert("Charge successful");
		});
	});
})(jQuery);
</script>
</body>
</html>