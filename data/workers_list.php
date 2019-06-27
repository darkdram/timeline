<?php

require '../system/config.php';

$query = "SELECT id, name FROM workers";

$res = $dbh->query($query);
$workers = $res->fetchAll( PDO::FETCH_ASSOC );

header('Content-Type: application/json; charset=utf8');
echo json_encode( $workers );