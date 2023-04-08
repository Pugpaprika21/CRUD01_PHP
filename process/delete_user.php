<?php

require __DIR__ . '../../src/include/include.php';

$http->headers('Access-Control-Allow-Origin: *')
     ->headers('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS')
     ->headers('Access-Control-Allow-Headers: *')
     ->headers('Access-Control-Max-Age:', '86400')
     ->headers('Content-type: application/json charset=utf-8');

if ($request['GET']['action'] == "delete_user") {
    $user_id = str($request['GET']['user_id']);

    $user_del = db_delete('user_tb', "user_id = '{$user_id}'");
    if ($user_del) {
        echo json_encode(['status' => 200]);
        exit;
    }
}

echo json_encode($request);
exit;
