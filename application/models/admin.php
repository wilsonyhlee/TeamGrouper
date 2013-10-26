<?php

class Admin {

	public static function checkAdmin() {
		if(!isset($_SESSION['admin'])) {
			$_SESSION['admin'] = false;
			return false;
		}
		if($_SESSION['admin'] == true) {
			return true;
		}
		else {
			return false;
		}
	}

	public static function login($username, $password) {
		if($username == 'admin' && $password == 'itp460') {
			$_SESSION['admin'] = true;
		}
		else {
			$_SESSION['admin'] = false;
		}
	}
	public static function logout() {
		$_SESSION['admin'] = false;
	}

}

?>