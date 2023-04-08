<?php

require __DIR__ . '../../src/include/include.php';

$http->headers('Access-Control-Allow-Origin: *')
     ->headers('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS')
     ->headers('Access-Control-Allow-Headers: *')
     ->headers('Access-Control-Max-Age:', '86400')
     ->headers('Content-type: application/json charset=utf-8');

$data = $request['CLIENT'];

if (str($data['action']) == 'insert') {

    $create['user_name'] = str($data['user_name']);
    $create['user_pass'] = str($data['user_pass']);
    $create['user_token'] = U_SYS_TOKEN;
    $create['user_status'] = 'Y';
    $create['create_user_at'] = '';
    $create['create_date_at'] = CREATE_DATE_AT;
    $create['create_time_at'] = CREATE_TIME_AT;
    $create['create_ip_at'] = U_IP;

    $user_id = db_insert('user_tb', $create, 'user_id');
    unset($create);

    $user = db_select('user_tb', '*', "user_id = '{$user_id}'");

    if (count($user) > 0) {
        echo json_encode(['status' => 200, 'path' => 'save_user.php']);
        exit;
    }
    echo json_encode(['status' => 500, 'path' => '']);
    exit;
}
