<?php

class Attendee extends Eloquent {

	public static function insert($data) {
		DB::table('attendees')->insert(array(
			'eventID' => $data['eventID'],
			'userID' => $data['userID'],
			'locationID' => $data['locationID']
		));
	}
	
	public static function check($data) {
		$query = DB::table('attendees')
			->where('eventID', '=', $data['eventID'])
			->where('userID', '=', $data['userID'])
			->where('locationID', '=', $data['locationID'])
			->first();
		
		if ($query) {
			return true;	
		}
		
		return false;
	}
	
	public static function count($data) {
		$count = DB::table('attendees')
			->where('eventID', '=', $data['eventID'])
			->where('locationID', '=', $data['locationID'])
			->count();
		
		return $count;
	}
}