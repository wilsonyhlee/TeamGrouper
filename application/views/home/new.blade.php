<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Test</title>
</head>
   
<body>
	<?= getenv("VCAP_SERVICES") ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>
	(function($) {
		$.ajax({
			type: "GET",
			dataType: "text",
			url: "{{ URL::to_action("home@user") }}"
		}).done(function(data) {
			console.log(data);
		});
	})(jQuery);
	</script>
</body>
</html>