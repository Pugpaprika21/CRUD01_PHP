<?php

require __DIR__ . '../../src/include/include.php';

$data = $request['GET'];

if ($data['action'] == 'get_users') {
    $users = db_excQuery("SELECT * FROM user_tb ORDER BY user_id DESC");
    echo json_encode($users);
    exit;
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


}
