<?php

require '../system/config.php';

$data = file_get_contents('php://input');

$result = array();

if (!empty($data)) {
    $json_data = json_decode($data, true);

    // var_dump($data, $json_data);

    if (isset($json_data['title'])) {
        $group_name = htmlspecialchars(trim($json_data['title']));
        try {
            $dbh->beginTransaction();
            $query = "INSERT INTO groups ( `name` ) VALUES ( '{$group_name}' )";
            $res = $dbh->query($query);
            $group_id = $dbh->lastInsertId();
            $dbh->commit();

            $result = array(
                'status' => 'success',
                'message' => 'Бригада  добавлена',
                'group' => array(
                    'name' => $group_name,
                    'id' => $group_id
                )
            );

            foreach ($json_data['workers'] as $worker) {
                $query = "INSERT INTO assigned_workers ( `id_worker`, `id_group` ) VALUES ( {$worker['id']}, {$group_id} )";
                $res = $dbh->query($query);

            }

        } catch (Exeption $e) {
            $result = array(
                'status' => 'error',
                'message' => $e->getMessage()
            );
        }

    } else {
        $result = array(
            'status' => 'error',
            'message' => 'Не удалось добавить новую бригаду'
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

