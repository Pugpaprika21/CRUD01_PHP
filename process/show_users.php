<?php

require __DIR__ . '../../src/include/include.php';

$data = $request['get'];

if ($data['action'] == 'get_users') {
    $users = db_select("user_tb", "*");
    echo json_encode($users);
    exit;
}