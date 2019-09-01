<?php

require '../system/config.php';

$data = file_get_contents('php://input');

$result = array();

if ( !empty($data) ) {
  $json_data = json_decode($data, true);

  $valid_errors = array();

  if ( !isset( $json_data['worker_id'] ) ) {
    $valid_errors['worker_id'] = 'Не указан прикрепляемый в бригаду работник';
  }

  if ( !isset( $json_data['group_id'] ) ) {
    $valid_errors['group_id'] = 'Не указана бригада для прикрепления работника';
  } 

  if ( count( $valid_errors ) > 0 ) {
    $result = array(
      'status' => 'error',
      'message' => 'При прикреплении работника к бригаде возникли следующие ошибки:',
      'errors' => $valid_errors
    );
  } else {
    $worker_id = intval( $json_data['worker_id'] );
    $group_id = intval( $json_data['group_id'] );
    try {

      $dbh->beginTransaction();
      $query = "INSERT IGNORE INTO assigned_groups ( `worker_id`, `group_id` ) VALUES ( :worker_id, :group_id )";
      $res = $dbh->prepare( $query );
      $res->bindParam( 'worker_id', $worker_id );
      $res->bindParam( 'group_id',  $group_id );
      $res->execute();
      $dbh->commit();

      $result = array(
        'status' => 'success',
        'message' => 'Работник успешно добавлен в бригаду'
      );
    } catch( Exeption $e ) {
      $result = array(
        'status' => 'error',
        'message' => $e->getMessage()
      );
    }
  }

} else {
  $result = array(
    'status' => 'error',
    'message' => 'bad request'
  );
}

header('Content-Type: application/json; charset=utf8');
echo json_encode( $result );

