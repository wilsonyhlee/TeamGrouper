(function($, Templates, moment) {
	var env = "",
		baseUrl = env === "dev" ? "http://localhost/ondeck" : "http://ondeckapp.aws.af.cm";

	var ajaxOpts = {
		type: "GET",
		url: baseUrl + "/public/home/events",
		dataType: "json"
	};
	
	var userID, eventID, locationID;

	// Page transition effect
	$(document).on("click", "a", function() {
		$(this).attr('data-transition','slide'); 
	}); 

	var toast= function(msg) {
		$("<div class='ui-loader ui-overlay-shadow ui-body-e ui-corner-all'><h3>"+msg+"</h3></div>")
			.css({ display: "block",
				opacity: 0.90,
				position: "fixed",
				padding: "7px",
				"text-align": "center",
				width: "270px",
				left: ($(window).width() - 284)/2,
				top: $(window).height()/2 
			})
			.appendTo( $.mobile.pageContainer ).delay( 1500 )
			.fadeOut( 400, function(){
				$(this).remove();
			});
	}

	// Login form
	$("#loginForm").on('submit', function(e) {
		var self = this;
		e.preventDefault();

		$.ajax({
			type: "GET",
			url: baseUrl + "/public/home/user",
			dataType: "json",
			data: $(self).serialize()
		}).done(function(data) {
			if (data.id) {
				userID = data.id;
				$.mobile.changePage("#Teams", { transition: "slide" });
			} else {
				$("#home").find(".message").html("Invalid email/password");
				toast("Invalid email/password")
			}
		});
	});

	// Registration form
	$("#registrationForm").on("submit", function(e) {
		var self = this;

		e.preventDefault();
		$.ajax({
			type: "POST",
			url: baseUrl + "/public/home/user",
			dataType: "json",
			data: $(self).serialize()
		}).done(function(data) {
			if (data.errors) {
				data.errors = data.errors.join("<br>");	
				$("#Registration").find(".message").html(data.errors);
				$.mobile.changePage("#Registration");
				toast("Invalid email/password.")
			} else {
				$("#home").find(".message").html(data.msg);
				toast("Successfully registered!")
				$.mobile.changePage("#home");
			}
		});
	});

	// Date events
	$(".getDate").on("click", function() {
		$.ajax(ajaxOpts).done(function(data) {
			var html = '';

			for (var i = 0, len = data.events.length; i < len; i++) {
				html += Templates.event(data.events[i]);
			}

			$("#Date").find("ul").html(html).listview("refresh");
		});
	});

	// Team page functionality
	(function() {
		var html = '',
			teams = [
				"Los Angeles Dodgers",
				"Los Angeles Lakers",
				"Los Angeles Kings",
				"Los Angeles Galaxy",
				"San Diego Chargers",
				"Oakland Raiders",
				"Golden State Warriors",
				"San Francisco 49ers"
			];

		for (var i = 0; i < teams.length; i++) {
			html += Templates.team({ 
				team: teams[i], 
				slug: teams[i].toLowerCase().replace(/ /g, '-'),
				logo: teams[i].split(' ')[teams[i].split(' ').length - 1].toLowerCase()
			});			
		}

		$("#Teams").find(".text-center")
			.html(html).end()
			.on("click", "a", function() {
				var team = $(this).attr("data-team"),
					slug = $(this).attr("data-slug");
				
				$(this).attr('data-transition','slide'); 
				$("#Events").attr("data-team", team);
				$("#Events").attr("data-slug", slug);
			});
	})();

	// Retrieve events for specified team for the Event page
	$(document)
		.on("pageshow", "#Events", function() {
			$("#Events").find("ul").html('');
			var team = $(this).attr("data-team");
			var slug = $(this).attr("data-slug");

			$("#Events .event-header .text").html("Events for " + team);
			$("#Events").find(".event-header img").show();
			
			$("#Locations .event-header .text").html("Watch the " + team);
			ajaxOpts.data = { team: slug };

			$.ajax(ajaxOpts).done(function(data) {
				var html = '';
				var c = new Date();
				c.setDate(c.getDate() + 3);
				
				$("#Locations").attr("data-lat", data.meta.geolocation.lat).attr("data-lon", data.meta.geolocation.lon);

				for (var i = 0, len = data.events.length; i < len; i++) {
					data.events[i].time = moment(data.events[i].datetime_local).format('h:mm a');
					data.events[i].datetime_local = new Date(data.events[i].datetime_local) > c ?  moment(data.events[i].datetime_local).format("dddd, MMM Do") : moment(data.events[i].datetime_local).format("dddd");

					html += Templates.event(data.events[i]);
				}

				$("#Events").find("ul").html(html).listview("refresh");
				$("#Events").find(".event-header img").hide();
			});
		});

	function getParameterByName(name) {
		return decodeURI(
			(RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
		);
	}
	
	// Event to location
	$("#Events").on("click", ".event-text", function(e) {
		$("#Locations").find("ul").html('');
		e.preventDefault();
		var $l = $("#Locations"),
			lat = $l.attr("data-lat"),
			lon = $l.attr("data-lon");

		$.mobile.changePage("#Locations", { transition: "slide" });
		$("#Locations").find(".event-header img").show();
		
		eventID = $(this).attr("data-seatgeekID");
		
		$.ajax({
			type: "GET",
			url: baseUrl + "/public/home/locations",
			dataType: "json",
			data: {
				lat: lat,
				lon: lon,
				query: "sports+bar"
			}
		}).done(function(data) {
			var html = '';
			
			for (var i = 0, len = data.response.venues.length; i < len; i++) {
				html += Templates.location(data.response.venues[i]);
			}

			$("#Locations").find("ul").html(html).listview("refresh");
			$("#Locations").find(".event-header img").hide();
		});
	});
	
	$("#Locations").on("click", ".event-text", function(e) {
		var $this = $(this),
			location = $this.find(".location").html(),
			team = $("#Events").attr("data-team"),
			coords = $this.find(".coords").html(),
			width = $(document).width() - 10;
		
		locationID = $this.attr("data-foursquareId");
		
		$("#Watch").find(".event-header").html(team + " at " + location);
		$("#googleMaps")[0].src = "http://maps.googleapis.com/maps/api/staticmap?center=" + coords + "&zoom=13&size=" + width + "x300&maptype=roadmap%20&markers=color:red|" + coords + "&sensor=false";
	});
	
	$(document)
		.on("pageshow", "#Watch", function() {
			$(".join").hide();
			$(".count").hide();
			$(".loader").show();
			
			$.ajax({
				type: "POST",
				dataType: "json",
				url: baseUrl + "/public/home/check",
				data: {
					eventID: eventID,
					userID: userID,
					locationID: locationID
				}
			}).done(function(data) {
				if (data.msg.indexOf("already joined") > -1) {
					$(".join").removeClass("active").addClass("past disabled").html("Already joined!");	
				} else {
					$(".join").removeClass("past disabled").addClass('active').html("Join");	
				}
				
				$(".join").show();
			});
			
			$.ajax({
				type: "POST",
				dataType: "json",
				url: baseUrl + "/public/home/count",
				data: {
					eventID: eventID,
					locationID: locationID
				}
			}).done(function(data) {
				var html;
				
				if (data.count === 0 || data.count === "0") {
					html = "No one is attending yet. Be the first to join this event!";	
				}
				else if (data.count === 1 || data.count === "1") {
					html = "One person is attending this event.";	
				}
				else {
					html = data.count + " people are attending this event.";
				}
				$(".count").html(html).attr("data-count", data.count).show();
				$(".loader").hide();
			});
		});
	
	$("#Watch").on("click", ".join.active", function(e) {
		e.preventDefault();
		$(this).removeClass('active').addClass('past disabled').html("Already joined!");
		
		var count = $(".count").attr("data-count"),
			html;
		
		console.log(count);
		if (count === 0 || count === "0") {
			html = "One person is attending this event.";	
		}
		else {
			html = (count+1) + " people are attending this event.";
		}
		
		$(".count").html(html).attr("data-count", count);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: baseUrl + "/public/home/join",
			data: {
				eventID: eventID,
				userID: userID,
				locationID: locationID
			}
		}).done(function(data) {
			console.log(data);
		});
	});
})(jQuery, Templates, moment);