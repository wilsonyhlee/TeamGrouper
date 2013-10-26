<?php

class CC {

	public static function retrieve($id) {
		$cards = DB::table('credit_cards')
			->where('customer_ID', '=', $id)
			->get();
			
		return $cards;
	}
	
	public static function retrieve_CID($id) {
		$customer_id = DB::table('credit_cards')
			->where('stripe_ID', '=', $id)
			->only('customer_ID');
			
		return $customer_id;
	}
	
	public static function insert($data) {
		DB::table('credit_cards')->insert(array(
			'stripe_ID' => $data['stripe_ID'],
			'customer_ID' => $data['customer_ID'],
			'type' => $data['type'],
			'last4' => $data['last4']
		));
	}
}