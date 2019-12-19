<?php

require $_SERVER['DOCUMENT_ROOT'] . '/system/config.php';

header("Content-Type: application/json; charset=utf-8");

$projectsRes = $dbh->query("select name, content, pr.id, g.id as `group` from projects pr left join assigned_groups ag  on ag.project_id = pr.id LEFT JOIN groups g on ag.group_id = g.id");

$struct = $projectsRes->fetchAll(PDO::FETCH_ASSOC);

// var_dump($struct);

// die();
for ($i = 0, $cnt = count($struct); $i < $cnt; $i++) {
    $workers = "SELECT w.name, aw.id_worker as id FROM `assigned_workers` aw left join workers w on aw.id_worker = w.id WHERE id_group = " . $struct[$i]['group'];
    // var_dump( $workers );
    $workersRes = $dbh->query($workers);
    $workersArr = $workersRes->fetchAll(PDO::FETCH_ASSOC);
    $struct[$i]['users'] = $workersArr;
    // $struct[ $i ][ 'group' ] = $struct[ $i ][ 'id' ];

    $timeschedule = "SELECT * FROM `timetable` WHERE `group` = " . $struct[$i]['group'] . " AND id_project = " . $struct[$i]['id'];
    // var_dump($timeschedule);
    // var_dump($dbh);
    $timescheduleRes = $dbh->query($timeschedule);
    $timescheduleArr = array();

    if ($timescheduleRes) {
        $timescheduleArr = $timescheduleRes->fetchAll(PDO::FETCH_ASSOC);
    }

    $struct[$i]['tasks'] = $timescheduleArr;
}

echo json_encode($struct);
