<?php

class Merchant {

	protected static $rules = array(
		'merchant' => 'required|max:50',
		'email' => 'required|max:100',
		'street_address' => 'required|min:5',
		'city_ID' => 'required',
		'zip' => 'required|numeric',
		'password' => 'required|min:5'
	);

	public static function validate($input) {
		$validation = new Validator($input, static::$rules);
		return $validation;
	}

	// used to list all merchants for 'Places to Shop' tab
	public static function all() {
		$merchants = DB::table('merchants')
			->get(array('merchant_ID', 'merchant'));

		return $merchants;
	}

	public static function allData() {
		return DB::table('merchants')->get();
	}
	
	public static function login($credentials) {
		$data = DB::table('merchants')
			->where('email', '=', $credentials['email'])
			->only('password');

		return $data;
	}
	
	public static function store($credentials) {
		$data = DB::table('merchants')
			->where('email', '=', $credentials['email'])
			->only('merchant_id');

		return $data;
	}

	public static function retrieve($id) {
		$merchant = DB::table('merchants')
			->join('cities', 'cities.city_id', '=', 'merchants.city_id')
			->where('merchant_ID', '=', $id)
			->get(array('merchant_ID', 'merchant', 'email', 'street_address', 'street_address2', 'merchants.city_ID', 'city', 'zip', 'phone', 	'url', 'logo'));

		return $merchant;
	}

	public static function insert($data) {
		DB::table('merchants')->insert(array(
			'merchant' => $data['merchant'],
			'email' => $data['email'],
			'street_address' => $data['street_address'],
			'street_address2' => $data['street_address2'],
			'city_ID' => $data['city_ID'],
			'zip' => $data['zip'],
			'phone' => $data['phone'],
			'url' => $data['url'],
			'logo' => $data['logo'],
			'password' => $data['password']
		));
	}

	public static function update($data) { 
		DB::table('merchants')
			->where('merchant_id', '=', $data['merchant_ID'])		
			->update(array(
				'merchant' => $data['merchant'],
				'email' => $data['email'],
				'street_address' => $data['street_address'],
				'street_address2' => $data['street_address2'],
				'city_ID' => $data['city_ID'],
				'zip' => $data['zip'],
				'phone' => $data['phone'],
				'url' => $data['url'],
				'logo' => $data['logo'],
				'password' => $data['password']
			));
	}
}