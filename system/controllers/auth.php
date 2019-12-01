<?php
/**
 * 
 */
class Auth
{
	
	function __construct()
	{
		// var_dump($_SESSION);
	}

	function isAuth() {
		return isset($_SESSION['auth']) && $_SESSION['auth'] == 'yes';
	}

	function getUserName() {
		$username = '';

		if ( $_SESSION['login'] == 'user1' ) {
			$username = 'Пользователь 1';
		} else if ( $_SESSION['login'] == 'user2' ) {
			$username = 'Пользователь 2';
		}

		return $username;
	}
}

