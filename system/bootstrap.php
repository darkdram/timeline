<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] .  '/system/controllers/auth.php';

$auth = new Auth();

if ( !$auth->isAuth() ) {
	header('Location: /login.php');
	exit();
}
