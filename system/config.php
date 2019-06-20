<?php

$dsn = 'mysql:dbname=timeschedule;host=localhost';
$user = 'root';
$password = '';

try {
  $dbh = new PDO($dsn, $user, $password);
  //var_dump($dbh);
} catch (PDOException $e) {
  echo 'Подключение не удалось: ' . $e->getMessage();
}


