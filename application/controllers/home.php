<?php

class Home_Controller extends Base_Controller {

	public function __construct() {
		// Auth filter requires logged in user session except for the register/login forms
		//$this->filter('before', array('auth'))
		//	->except(array('user'));
		
		// Allow cross-origin requests, necessary for PhoneGap app to communicate with server
		$this->filter('after', 'CORS');
		
		$this->baseAPIUrl = "http://api.seatgeek.com/2/";
		$this->dateTimeUrl = $this->baseAPIUrl . "events?per_page=50&range=1000mi&datetime_utc.gte=";
		$this->ip = "&geoip=" . Utility::ip();
		$this->today = Utility::now();
		
		$this->_foursquareClient = "W0KZY3Q33VBVU21EBJ3MQ4W2Z4J445A00VN32OSWHMCIWAKN";
		$this->_foursquareSecret = "3VQKUSVX3RCB0BBTULNTBBP1L5BABII1QXHWWRFH4CVSYIUV";
	}

	// Restrict controller actions to certain RESTful requests
	public $restful = true;
	
	public function get_events() {
		$date = (Input::get("date") != null) ? Input::get("date") : $this->today;
		$team = (Input::get("team") != null) ? "&performers.slug=" . Input::get("team") : '';
		$url = $this->dateTimeUrl . $date . $this->ip . $team;
		return file_get_contents($url);
	}
	
	public function post_user() {
		$input = Input::all();
		$validation = User::validate($input);
		
		if ($validation->fails() ) {
			return json_encode(array('errors' => $validation->errors->all() ));
		}
		else {
			User::insert($input);
			return json_encode(array('msg' => "Account successfully registered."));
		}
	}
	
	public function get_user() {
		$credentials = Input::all();
		
		if (Auth::attempt($credentials)) {
			$id = Auth::user()->id;
			return json_encode(array('id' => $id) );
		} else {
			return json_encode(array('errors' => "failed") );
		}
	}
	
	public function get_locations() {
		$lat = (Input::get("lat") != null) ? Input::get("lat") : 0;
		$lon = (Input::get("lon") != null) ? Input::get("lon") : 0;
		$query = (Input::get("query") != null) ? Input::get("query") : " ";
		$url = "https://api.foursquare.com/v2/venues/search?client_id=" . $this->_foursquareClient . "&client_secret=" . $this->_foursquareSecret . "&v=20130815&ll=" . $lat . "," . $lon . "&query=" . $query; 
			
		return file_get_contents($url);
	}
	
	public function post_join() {
		$input = Input::all();
		Attendee::insert($input);
		
		return json_encode(array('msg' => 'Added attendee'));
	}
	
	public function post_check() {
		$input = Input::all();
		$check = Attendee::check($input);
		
		if ($check) {
			return json_encode(array('msg' => 'already joined'));	
		}
		
		return json_encode(array('msg' => 'not joined'));
	}
	
	public function post_count() {
		$input = Input::all();
		$count = Attendee::count($input);
		
		return json_encode(array('count' => $count));
	}
}