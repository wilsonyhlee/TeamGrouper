<?php

class City {
	
	public static function all() {
		$cities = DB::table('cities')
			->get(array('city_ID', 'city'));
			
		return $cities;
	}

	public static function retrieve($id) {
		$city = DB::table('cities')
			->where('city_ID', '=', $id)
			->get();
			
		return $city;
	}
}