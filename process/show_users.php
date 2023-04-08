<?php

require __DIR__ . '../../src/include/include.php';

$http->headers('Access-Control-Allow-Origin: *')
     ->headers('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS')
     ->headers('Access-Control-Allow-Headers: *')
     ->headers('Access-Control-Max-Age:', '86400')
     ->headers('Content-type: application/json charset=utf-8');

if ($request['GET']['action'] == 'get_users') {
    $users = db_excQuery("SELECT * FROM user_tb ORDER BY user_id DESC");
    echo json_encode($users);
    exit;
}
    // $query_meetroom = db_excQuery(
    //     "SELECT *
    //         FROM rooms
    //         WHERE room_id NOT IN (
    //         SELECT room_id
    //         FROM reservations
    //         WHERE (
    //             (start_datetime >= '2023-04-07 09:00:00' AND end_datetime <= '2023-04-07 10:00:00')
    //             OR (start_datetime <= '2023-04-07 09:00:00' AND end_datetime >= '2023-04-07 10:00:00')
    //             OR (start_datetime <= '2023-04-07 09:00:00' AND end_datetime >= '2023-04-07 09:00:00')
    //             OR (start_datetime <= '2023-04-07 10:00:00' AND end_datetime >= '2023-04-07 10:00:00')
    //         ) AND date = '2023-04-07'
    //         ) AND room_type = 'standard'
    //     "

    // ,function ($resQuery) {

    // });



