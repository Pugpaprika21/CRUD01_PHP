<?php

require __DIR__ . '../../src/include/include.php';

$http->headers('Access-Control-Allow-Origin: *')
     ->headers('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS')
     ->headers('Access-Control-Allow-Headers: *')
     ->headers('Access-Control-Max-Age:', '86400')
     ->headers('Content-type: application/json charset=utf-8');

$data = $request['client'];

if ($request['get']['action'] == 'edit_user_data') {

    $update['user_name'] = str($data['user_name']);
    $update['user_pass'] = str($data['user_pass']);
    $update['user_token'] = U_SYS_TOKEN;
    $update['user_status'] = 'U';
    $update['create_user_at'] = '';
    $update['create_date_at'] = CREATE_DATE_AT;
    $update['create_time_at'] = CREATE_TIME_AT;
    $update['create_ip_at'] = U_IP;
    $user_id = str($data['user_id']);

    $user_edit = db_update('user_tb', $update, "user_id = '{$user_id}'");
    unset($update);

    if ($user_edit) {
        $user_edit_data = db_select('user_tb', '*', "user_id = '{$user_id}' ORDER BY user_id DESC");
        echo json_encode($user_edit_data);
        exit;
    }
}

echo json_encode($body);
exit;
