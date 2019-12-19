<?php

require '../system/config.php';

$data = file_get_contents('php://input');

$result = array();

if (!empty($data)) {
    $json_data = json_decode($data, true);

    // var_dump($data, $json_data);

    if (isset($json_data['name'])) {
        $worker_name = htmlspecialchars(trim($json_data['name']));
        try {
            $dbh->beginTransaction();
            $query = "INSERT INTO workers ( `name` ) VALUES ( '{$worker_name}' )";
            $res = $dbh->query($query);
            $worker_id = $dbh->lastInsertId();
            $dbh->commit();

            $result = array(
                'status' => 'success',
                'worker' => array(
                    'name' => $worker_name,
                    'id' => $worker_id
                )
            );
        } catch (Exeption $e) {
            $result = array(
                'status' => 'error',
                'message' => $e->getMessage()
            );
        }

    } else {
        $result = array(
            'status' => 'error',
            'message' => 'Не удалось добавить нового работника'
        );
    }
} else {
    $result = array(
        'status' => 'error',
        'message' => 'bad request'
    );
}

header('Content-Type: application/json; charset=utf8');
echo json_encode($result);
