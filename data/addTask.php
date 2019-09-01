<?php

require '../system/config.php';

$data = file_get_contents('php://input');

$json = json_decode( $data, true );

//default dates
$dates = array(
  'real' => array(
    'admittance' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    ),
    'work' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    ),
    'report' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    )
  ),
  'contract' => array(
    'work' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    ),
    'report' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    )
  )
);

$errors = array();

if ( isset($json['times']) ) {
  $_times = $json['times'];

  foreach ($_times as $time_type => $time_times) {
    //$time_type = real, contract
    foreach ($time_times as $time_sub_type => $new_times) {
      // $time_sub_type = admittance, work, report
 
      if ( isset( $dates[$time_type][$time_sub_type] ) ) {
        foreach ($new_times as $tt => $tv) {
          //$tt - start(0), end(1)
          // if ( v::date('Y-m-d')->validate( $tv ) ) {
            $idx = $tt == 0  ? 'start' : 'end';
            $dates[$time_type][$time_sub_type][ $idx ] = $tv;
          // echo '$dates[' . $time_type . '][' . $time_sub_type. '][' . $idx . '] = \'' . $tv . '\'' . PHP_EOL;

          // }
        }
      }
    }
  }
}

$project_real_admittance_start     =  $dates['real']['admittance']['start'];                 // '1971-01-01';
$project_real_admittance_end       =  $dates['real']['admittance']['end'];                   // '1971-02-01';
$project_real_work_start           =  $dates['real']['work']['start'];                       // '1971-02-02';
$project_real_work_end             =  $dates['real']['work']['end'];                         // '1971-08-08';
$project_real_report_start         =  $dates['real']['report']['start'];                     // '1971-08-09';
$project_real_report_end           =  $dates['real']['report']['end'];                       // '1971-08-09';

$project_contract_work_start       =  $dates['contract']['work']['start'];                   // '1971-02-02';
$project_contract_work_end         =  $dates['contract']['work']['end'];                     // '1971-08-18';
$project_contract_report_start     =  $dates['contract']['report']['start'];                 // '1971-08-19';
$project_contract_report_end       =  $dates['contract']['report']['end'];                   // '1971-08-19';


$project_name = $json['task']['name'];

$taskNames = array(
  'real' => array(
    'admittance' => 'Допуск',
    'work' => 'Реальные сроки проведения работ',
    'report' => 'реальные сроки сдачи технических отчетов'
  ),
  'contract' => array(
    'work' => 'Договорные сроки проведения работ',
    'report' => 'Договорные сроки сдачи технических отчетов'
  )
);


$dbh->beginTransaction();
$query = "INSERT INTO projects ( `content` ) VALUES ( '{$project_name}' )";
$res = $dbh->query( $query );
$project_id = $dbh->lastInsertId();


$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$project_name}',                        {$project_id}, '{$project_contract_start}',            '{$project_contract_end}',            '{$project_id}', 'background', 'contract', 'title' )"); var_dump( $dbh->errorInfo() );
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['real']['admittance']}',     {$project_id}, '{$project_real_admittance_start}',     '{$project_real_admittance_end}',     '{$project_id}', 'range',      'real'    , 'admittance' )"); var_dump( $dbh->errorInfo() );
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['real']['work']}',           {$project_id}, '{$project_real_work_start}',           '{$project_real_work_end}',           '{$project_id}', 'range',      'real'    , 'work' )"); var_dump( $dbh->errorInfo() );
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['contract']['work']}',       {$project_id}, '{$project_contract_work_start}',       '{$project_contract_work_end}',       '{$project_id}', 'range',      'contract', 'work' )"); var_dump( $dbh->errorInfo() );
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['real']['report']}' ,        {$project_id}, '{$project_real_report_start}',         '{$project_real_report_end}',         '{$project_id}', 'range',      'real'    , 'report' )"); var_dump( $dbh->errorInfo() );
$dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['contract']['report']}' ,    {$project_id}, '{$project_contract_report_start}',     '{$project_contract_report_end}',     '{$project_id}', 'range',      'contract', 'report' )"); var_dump( $dbh->errorInfo() );

$dbh->commit();


