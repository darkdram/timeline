<?php

require '../system/config.php';

$data = file_get_contents('php://input');

$result = array();

if ( !empty($data) ) {
  $json_data = json_decode($data, true);

  // var_dump($data, $json_data);

  if ( isset( $json_data['group_id'] ) ) {
    $worker_id = intval( $json_data['worker_id'] );

    try {
      $dbh->beginTransaction();
      $query = "DELETE FROM assigned_groups WHERE worker_id = {$worker_id}";
      $res = $dbh->query( $query );
      // var_dump( $res, $query, $dbh->errorInfo() );
    
      if ( $res ) {
        $query = "DELETE FROM workers WHERE id = {$worker_id}";
        $res = $dbh->query( $query );    

        if ( $res ) {
          $dbh->commit();

          $result = array(
            'status' => 'success',
            'message' => 'Работник удален'
          );
        } else {
          $dbh->rollBack();
          $er = new Exception('Не удалось удалить работника');
        }   
      } else {
        $er = new Exception('Не удалось удалить работника');
      }

      // var_dump( $res, $query, $dbh->errorInfo() );

    } catch( Exeption $e ) {
      $result = array(
        'status' => 'error',
        'message' => $e->getMessage()
      );
    }

  } else {
    $result = array(
      'status' => 'error',
      'message' => 'Не удалось удалить работника'
    );
  }
} else {
  $result = array(
    'status' => 'error',
    'message' => 'bad request'
  );
}

header('Content-Type: application/json; charset=utf8');
echo json_encode( $result );

