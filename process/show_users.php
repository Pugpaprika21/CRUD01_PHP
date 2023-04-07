<?php

require __DIR__ . '../../src/include/include.php';

$data = $request['get'];

if ($data['action'] == 'get_users') {
    $users = db_excQuery("SELECT * FROM user_tb ORDER BY user_id DESC");
    echo json_encode($users);
    exit;
}