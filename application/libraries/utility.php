<?php

class Utility {

	public static function ip() {
		Symfony\Component\HttpFoundation\Request::trustProxyData();
		$ip = Request::ip();
		$ip = ($ip !== "::1") ? $ip : "true";
		return $ip;
	}
	
	public static function now() {
		return date("Y-m-d");	
	}
}