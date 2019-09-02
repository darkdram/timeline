<?php

require '../system/config.php';

$data = file_get_contents('php://input');

$json = json_decode( $data, true );

// var_dump($json);

// //default dates
// $dates = array(
//   'real' => array(
//     'admittance' => array(
//       'start' => '0000-00-00',
//       'end'   => '0000-00-00'
//     ),
//     'work' => array(
//       'start' => '0000-00-00',
//       'end'   => '0000-00-00'
//     ),
//     'report' => array(
//       'start' => '0000-00-00',
//       'end'   => '0000-00-00'
//     )
//   ),
//   'contract' => array(
//     'work' => array(
//       'start' => '0000-00-00',
//       'end'   => '0000-00-00'
//     ),
//     'report' => array(
//       'start' => '0000-00-00',
//       'end'   => '0000-00-00'
//     )
//   )
// );

// $errors = array();

// if ( isset($json['dates']) ) {
//   $_dates = $json['dates'];

//   foreach ($_dates as $date_type => $time_dates) {
//     //$date_type = real, contract
//     foreach ($time_dates as $time_sub_type => $new_dates) {
//       // $time_sub_type = admittance, work, report
 
//       if ( isset( $dates[$date_type][$time_sub_type] ) ) {
//         foreach ($new_dates as $tt => $tv) {
//           //$tt - start(0), end(1)
//           // if ( v::date('Y-m-d')->validate( $tv ) ) {
//             $idx = $tt == 0  ? 'start' : 'end';
//             $dates[$date_type][$time_sub_type][ $idx ] = $tv;
//           // echo '$dates[' . $date_type . '][' . $time_sub_type. '][' . $idx . '] = \'' . $tv . '\'' . PHP_EOL;

//           // }
//         }
//       }
//     }
//   }
// }

$project_real_admittance_start     =  $json['dates']['real']['adm']['start'];                 // '1971-01-01';
$project_real_admittance_end       =  $json['dates']['real']['adm']['end'];                   // '1971-02-01';
$project_real_work_start           =  $json['dates']['real']['work']['start'];                       // '1971-02-02';
$project_real_work_end             =  $json['dates']['real']['work']['end'];                         // '1971-08-08';
$project_real_report_start         =  $json['dates']['real']['report']['end'];                     // '1971-08-09';
$project_real_report_end           =  $json['dates']['real']['report']['send'];                       // '1971-08-09';

$project_contract_work_start       =  $json['dates']['contract']['start'];                   // '1971-02-02';
$project_contract_work_end         =  $json['dates']['contract']['end'];                     // '1971-08-18';
$project_contract_report_start     =  $json['dates']['contract']['report'];                 // '1971-08-19';
$project_contract_report_end       =  $json['dates']['contract']['report'];                   // '1971-08-19';



// var_dump( $project_real_admittance_start );
// var_dump( $project_real_admittance_end );
// var_dump( $project_real_work_start );
// var_dump( $project_real_work_end );
// var_dump( $project_real_report_start );
// var_dump( $project_real_report_end );
// var_dump( $project_contract_work_start );
// var_dump( $project_contract_work_end );
// var_dump( $project_contract_report_start );
// var_dump( $project_contract_report_end );



$project_name = $json['project_name'];

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

// var_dump( $dates );


$ress = array( 'status' => 'success', 'message' => 'Объект успешно добавлен' );

$dbh->beginTransaction();
$query = "INSERT INTO projects ( `content` ) VALUES ( '{$project_name}' )";
$res = $dbh->query( $query );
$project_id = $dbh->lastInsertId();
$group_id = intval($json['group']);

if ( !$res ) {

  $resss = array( 'status' => 'fail', 'message' => 'Объект не удалось добавить' );

  $dbh->rollBack();
} else {
  $dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$project_name}',                        {$project_id}, '{$project_contract_work_start}',       '{$project_contract_work_end}',       '{$group_id}', 'background', 'contract', 'title' )");  // var_dump( $dbh->errorInfo() );
  $dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['real']['admittance']}',     {$project_id}, '{$project_real_admittance_start}',     '{$project_real_admittance_end}',     '{$group_id}', 'range',      'real'    , 'admittance' )");  // var_dump( $dbh->errorInfo() );
  $dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['real']['work']}',           {$project_id}, '{$project_real_work_start}',           '{$project_real_work_end}',           '{$group_id}', 'range',      'real'    , 'work' )");  // var_dump( $dbh->errorInfo() );
  $dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['contract']['work']}',       {$project_id}, '{$project_contract_work_start}',       '{$project_contract_work_end}',       '{$group_id}', 'range',      'contract', 'work' )");  // var_dump( $dbh->errorInfo() );
  $dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['real']['report']}' ,        {$project_id}, '{$project_real_report_start}',         '{$project_real_report_end}',         '{$group_id}', 'point',      'real'    , 'report' )");  // var_dump( $dbh->errorInfo() );
  $dbh->query("INSERT INTO timetable ( `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype` ) VALUES ( '{$taskNames['contract']['report']}' ,    {$project_id}, '{$project_contract_report_start}',     '{$project_contract_report_end}',     '{$group_id}', 'point',      'contract', 'report' )");  // var_dump( $dbh->errorInfo() );


  $dbh->query( "INSERT INTO `assigned_groups`( `project_id`, `group_id`) VALUES ({$project_id},{$group_id})" );

  $dbh->commit();
}

header('Content-Type: application/json; charset=utf8');
echo json_encode( $ress );

