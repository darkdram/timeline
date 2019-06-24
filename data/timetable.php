<?php

require $_SERVER['DOCUMENT_ROOT'] . '/system/config.php';

header( "Content-Type: application/json; charset=utf-8" );

$projectsRes = $dbh->query( "SELECT * FROM `projects`" );

$struct = $projectsRes->fetchAll(PDO::FETCH_ASSOC);

for( $i=0, $cnt = count( $struct ); $i < $cnt; $i++ ) {
  $workers = "SELECT w.id, w.name FROM `assigned_workers` aw LEFT JOIN `workers` w ON aw.id_worker = w.id WHERE aw.id_project = " . $struct[ $i ]['id'];
  $workersRes = $dbh->query( $workers );
  $workersArr = $workersRes->fetchAll( PDO::FETCH_ASSOC );
  $struct[ $i ][ 'users' ] = $workersArr;
  $struct[ $i ][ 'group'   ] = $struct[ $i ][ 'id' ];

  $timeschedule = "SELECT * FROM `timetable` WHERE `group` = " . $struct[ $i ][ 'id' ];
  // var_dump($timeschedule);
  // var_dump($dbh);
  $timescheduleRes = $dbh->query( $timeschedule );
  $timescheduleArr = array();

  if ( $timescheduleRes ) {
    $timescheduleArr = $timescheduleRes->fetchAll( PDO::FETCH_ASSOC );    
  }

  $struct[ $i ][ 'tasks' ] = $timescheduleArr;
}

echo json_encode($struct);
