<?php

require __DIR__ . '../../src/include/include.php';

if (str($_POST['btn_add']) != '') {

    $create['user_name'] = str($_POST['user_name']);
    $create['user_pass'] = str($_POST['user_pass']);
    $create['user_token'] = U_SYS_TOKEN;
    $create['user_status'] = 'Y';
    $create['create_user_at'] = $_SESSION['user_id'];
    $create['create_date_at'] = CREATE_DATE_AT;
    $create['create_time_at'] = CREATE_TIME_AT;
    $create['create_ip_at'] = U_IP;

    $user_id = db_insert('user_tb', $create, 'user_id');
    unset($create);

    $user = db_select('user_tb', '*', "user_id = '{$user_id}'");

    if (count($user) > 0) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_pass'] = $user['user_pass'];
        $_SESSION['user_data'] = $user;
        redirect_to('../pages/index', ['msg' => 'insert success']);
    }
}
