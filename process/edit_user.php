<?php

require __DIR__ . '../../src/include/include.php';
// echo_r($_REQUEST);
if (str($_GET['user_id']) != '') {

    $user_id = str($_GET['user_id']);

    $user = db_select('user_tb', '*', "user_id = '{$user_id}'");

    $update['user_data'] = $user;
    $update['status_data'] = 'Y';
    $_SESSION['user_edit_data'] = $update;
    unset($update);

    redirect_to('../pages/index');
}
