<?php

require '../system/config.php';

$data = file_get_contents('php://input');

$result = array();

if (!empty($data)) {
    $json_data = json_decode($data, true);

    if (isset($json_data['name'])) {
        $worker_name = htmlspecialchars(trim($json_data['name']));
        $worker_id = intval($json_data['id']);

        try {
            $dbh->beginTransaction();
            $query = "UPDATE workers SET `name` = '{$worker_name}' WHERE `id` =  {$worker_id}";
            $res = $dbh->query($query);
            $worker_id = $dbh->lastInsertId();
            $dbh->commit();

            $result = array(
                'status' => 'success'
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
            'message' => 'Не сохранить работника'
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
