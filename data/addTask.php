<?php

require '../system/config.php';

$project_name = 'Задача 7';

$project_real_admittance_start     = '1971-01-01';
$project_real_admittance_end       = '1971-02-01';
$project_real_work_start           = '1971-02-02';
$project_real_work_end             = '1971-08-08';
$project_real_report_start         = '1971-08-09';
$project_real_report_end           = '1971-08-09';

$project_contract_admittance_start = '1971-01-01';
$project_contract_admittance_end   = '1971-02-01';
$project_contract_work_start       = '1971-02-02';
$project_contract_work_end         = '1971-08-18';
$project_contract_report_start     = '1971-08-19';
$project_contract_report_end       = '1971-08-19';

$dbh->beginTransaction();
$query = "INSERT INTO projects ( `content` ) VALUES ( '{$project_name}' )";
$res = $dbh->query( $query );
$project_id = $dbh->lastInsertId();


$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype` ) VALUES ( '{$project_name}', '{$project_id}', '{$project_contract_start}',            '{$project_contract_end}',            '{$project_id}', 'background', 'contract' )");
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype` ) VALUES ( 'Допуск',          '{$project_id}', '{$project_real_admittance_start}',     '{$project_real_admittance_end}',     '{$project_id}', 'range',      'real'     )");
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype` ) VALUES ( 'Допуск',          '{$project_id}', '{$project_contract_admittance_start}', '{$project_contract_admittance_end}', '{$project_id}', 'range',      'contract' )");
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype` ) VALUES ( 'Работа',          '{$project_id}', '{$project_real_work_start}',           '{$project_real_work_end}',           '{$project_id}', 'range',      'real'     )");
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype` ) VALUES ( 'Работа',          '{$project_id}', '{$project_contract_work_start}',       '{$project_contract_work_end}',       '{$project_id}', 'range',      'contract' )");
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype` ) VALUES ( 'Отчет' ,          '{$project_id}', '{$project_real_report_start}',         '{$project_real_report_end}',         '{$project_id}', 'range',      'real'     )");
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype` ) VALUES ( 'Отчет' ,          '{$project_id}', '{$project_contract_report_start}',     '{$project_contract_report_end}',     '{$project_id}', 'range',      'contract' )");

$dbh->commit();


