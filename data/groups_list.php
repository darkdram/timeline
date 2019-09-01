<?php

require '../system/config.php';

$query = "SELECT g.id as gid, g.name as gname, ag.worker_id as agwi, w.name as wname FROM `groups` g  left join assigned_groups ag on g.id = ag.group_id LEFT join workers w on ag.worker_id = w.id order by g.id";

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