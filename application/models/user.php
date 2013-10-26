<?php

class User extends Eloquent {
	protected static $rules = array(
		'email' => 'required|email|max:100|unique:users',
		'password' => 'required|min:5|confirmed'
	);

	public static function validate($input) {
		$validation = new Validator($input, static::$rules);
		return $validation;
	}
	
	public static function insert($data) {
		DB::table('users')->insert(array(
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		));
	}
}