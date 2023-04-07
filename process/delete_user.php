<?php

require __DIR__ . '../../src/include/include.php';

$user_id = str($_GET['user_id']);

$res = db_delete('user_tb', "user_id = '{$user_id}'");

if ($res) {
    redirect_to('../pages/index', ['msg' => 'deleted']);
}
redirect_to('../pages/index', ['msg' => 'error']);
