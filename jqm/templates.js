(function(_) {
	var Templates = window.Templates = {};
	
	Templates.event = [
		'<li>', 
			'<div class="float-left" style="width: 15%; padding-right: 5%">',
				'<a href="<%= url %>"><img src="img/buy_tickets.png" width="100%"></a>',
			'</div>',
			'<div class="float-left" style="width: 79%">',
				'<div class="event-text" data-seatgeekId="<%= id %>">',
					'<a href="#Locations">',
						'<%= datetime_local %> <br>',
						'<%= title %> <br>',
						'<%= time %>',
					'</a>',
				'</div>',
			'</div>',
			'<div class="clear"></div>',
		'</li>'
	];
	
	Templates.location = [
		'<li data-id="<%= id %>">',
			'<div class="float-left" style="width: 15%; padding-right: 5%">',
				'<% if (typeof(menu) !== "undefined") { %> <a href="<%= menu.mobileUrl %>"><img src="img/menu_foursquare.png" width="100%"></a> <% } %>',
				'<% if (typeof(menu) === "undefined") { %> <a href="#"><img src="img/no_menu.png" width="100%"></a> <% } %>',
			'</div>',
			'<div class="float-left" style="width: 79%">',
				'<div class="event-text" data-foursquareId="<%= id %>">',
					'<a href="#Watch">',
						'<span class="location"><%= name %></span> <br>',
						'<%= location.address %> <br>',
						'<%= location.city %>, <%= location.state %>',
						'<span class="hide coords"><%= location.lat %>,<%= location.lng %></span>',
					'</a>',
				'</div>',
			'</div>',
			'<div class="clear"></div>',
		'</li>'
	];
	
	Templates.team = [
		'<a href="#Events" data-team="<%= team %>" data-slug="<%= slug %>"> <img src="img/<%= logo %>.png" class="logo"> </a>'
	];

	for (var tmpl in Templates) {
		if (Templates.hasOwnProperty(tmpl)) {
			Templates[tmpl] = _.template(Templates[tmpl].join('\n'));	
		}
	}
	
	console.log(Templates);
})(_);