<?php

require __DIR__ . '../../src/include/include.php';

$http->headers('Access-Control-Allow-Origin: *')
     ->headers('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS')
     ->headers('Access-Control-Allow-Headers: *')
     ->headers('Access-Control-Max-Age:', '86400')
     ->headers('Content-type: application/json charset=utf-8');

$data = $request['get'];

// if ($data['action'] == 'edit_user_data') {
//     $user_id = str($data['user_id']);

//     $user_edit_data = db_select('user_tb', '*', "user_id = '{$user_id}'");
//     echo json_encode($user_edit_data);
//     exit;
// }

echo json_encode($data);
exit;
