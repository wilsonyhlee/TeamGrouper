<?php

class Customer {
	protected static $rules = array(
		'first_name' => 'required|max:50',
		'last_name' => 'required|max:50',
		'email' => 'required|email|max:100|unique:customers',
		'password' => 'required|min:5',
		'pin' => 'required|numeric'
	);

	public static function validate($input) {
		$validation = new Validator($input, static::$rules);
		return $validation;
	}

	public static function retrieve($id) {
		$customer = DB::table('customers')
			->where('id', '=', $id)
			->first();
			
		return $customer;
	}
	
	public static function insert($data) {
		DB::table('customers')->insert(array(
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'email' => $data['email'],
			'password' => $data['password'],
			'pin' => $data['pin']
		));
	}
	
	public static function update($data) {
		DB::table('customers')
			->where('id', '=', $data['customer_ID'])		
			->update(array(
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'email' => $data['email'],
				'password' => $data['password'],
				'pin' => $data['pin']
			));
	}
}