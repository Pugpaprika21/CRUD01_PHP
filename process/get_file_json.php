<?php

require __DIR__ . '../../src/include/include.php';

if ($request['GET']['action'] == 'load_json') {

    $json_users = db_select("user_tb");
    $json_convert = json_encode(['JSON_DATE_ADD' => CREATE_DATE_AT .' '. CREATE_TIME_AT, 'JSON_DATA' => $json_users]);

    write_json($json_convert, '../logs/json/users_json_data.json', true);

    //download_file('../logs/json/users_json_data.json');

    redirect_to("../pages/index", ['load_json' => 'true']);
}
