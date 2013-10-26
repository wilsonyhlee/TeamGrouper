<?php

class Charity {
	
	public static function all() {
		$charities = DB::table('charities')
			->get(array('charity_ID', 'charity'));
			
		return $charities;
	}

	public static function retrieve($id) {
		$charity = DB::table('charities')
			->where('charity_ID', '=', $id)
			->get();
			
		return $charity;
	}
}