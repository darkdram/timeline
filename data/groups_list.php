<?php

require '../system/config.php';

$query = "select g.id as gid, g.name as gname, aw.id_worker as agwi, w.name as wname from groups g left JOIN assigned_workers aw on g.id = aw.id_group LEFT join workers w on w.id = aw.id_worker";

$res = $dbh->query($query);
$workers = $res->fetchAll( PDO::FETCH_ASSOC );


$groups = array();
foreach( $workers as $k=>$w ) {
	if ( !isset( $groups[ $w['gid'] ] ) ) {
		$groups[ $w['gid'] ] = array();
		$groups[ $w['gid'] ]['name'] = $w['gname'];
		$groups[ $w['gid'] ]['id'] = $w['gid'];
		$groups[ $w['gid'] ]['workers'] = array(); 
	}

	if ( $w['wname'] !== null && $w['agwi'] !== null) {
		$groups[ $w['gid'] ]['workers'] = array( 'id' => $w['agwi'], 'name' => $w['wname'] ); 
	}
}

header('Content-Type: application/json; charset=utf8');
// echo json_encode( $workers );
echo json_encode( $groups );