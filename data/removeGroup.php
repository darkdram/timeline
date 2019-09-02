<?php

require '../system/config.php';

$data = file_get_contents('php://input');

$result = array();

if ( !empty($data) ) {
  $json_data = json_decode($data, true);

  // var_dump($data, $json_data);

  if ( isset( $json_data['group_id'] ) ) {
    $group_id = intval( $json_data['group_id'] );

    try {
      $dbh->beginTransaction();
      $query = "DELETE FROM assigned_workers WHERE group_id = {$group_id}";
      $res = $dbh->query( $query );
      // var_dump( $res, $query, $dbh->errorInfo() );
    
      // if ( $res ) {
         $query = "DELETE FROM groups WHERE id = {$group_id}";
        $res = $dbh->query( $query );    

        if ( $res ) {
          $dbh->commit();

          $result = array(
            'status' => 'success',
            'message' => 'Бригада удалена'
          );
        } else {
          $dbh->rollBack();
          $er = new Exception('Не удалось удалить бригаду');
        }   
      // } else {
      //   $er = new Exception('Не удалось удалить работника');
      // }

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
      'message' => 'Не удалось удалить бригаду'
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

