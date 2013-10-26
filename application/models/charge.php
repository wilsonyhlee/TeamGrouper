<?php

class Charge {

	public static function all() {
		$charges = DB::table('charges')
			->join('merchants', 'charges.merchant_ID', '=', 'merchants.merchant_ID')
			->join('charities', 'charges.charity_ID', '=', 'charities.charity_ID')
			->join('customers', 'charges.customer_ID', '=', 'customers.id')
			->get(array(
				'charge_ID',
				'merchant',
				'first_name',
				'last_name',
				'charity',
				'datetime',
				'amount'
			));

		return $charges;
	}

	public static function insert($data) {
		DB::table('charges')->insert(array(	
			'charge_ID' => $data['charge_ID'],
			'merchant_ID' => $data['merchant_ID'],
			'customer_ID' => $data['customer_ID'],
			'charity_ID' => $data['charity_ID'],
			'datetime' => $data['datetime'],
			'amount' => $data['amount']
		));
	}
	
	public static function retrieve_for_customer($id) {
		$charges = DB::table('charges')
			->join('merchants', 'charges.merchant_ID', '=', 'merchants.merchant_ID')
			->join('charities', 'charges.charity_ID', '=', 'charities.charity_ID')
			->where('customer_ID', '=', $id)
			->get(array('charge_ID','datetime','amount'));
			
		return $charges;
	}
	
	public static function retrieve_for_merchant($id) {
		$charges = DB::table('charges')
			->join('customers', 'charges.customer_ID', '=', 'customers.id') 
			->join('charities', 'charges.charity_ID', '=', 'charities.charity_ID')
			->where('merchant_ID', '=', $id)
			->get(array('charge_ID','datetime','amount'));
			
		return $charges;
	}
}