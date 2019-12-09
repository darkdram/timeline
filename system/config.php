<?php

$dsn = 'mysql:dbname=timeline;host=localhost';
$user = 'admin';
$password = '123qaz';

try {
	$dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //var_dump($dbh);
} catch (PDOException $e) {
  echo 'Подключение не удалось: ' . $e->getMessage();
}


