<?php

// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);

session_start();

date_default_timezone_set('Asia/Bangkok');

/* vars */
$create = [];
$update = [];

$path = __DIR__ . '../../';

$cf = require "{$path}configs/public_settings.php";

require "{$path}functions/helpers.php";
require "{$path}functions/mysqli_db.php";
require "{$path}classes/Http.php";

define('JS_AJAX', $cf['JS']['AJAX']);
define('JS_AXIOS', $cf['JS']['AXIOS']);
define('JS_FETCH', $cf['JS']['FETCH']);
define('JS_BOOTSTRAP', $cf['JS']['BOOTSTRAP']);
define('JS_SWL', $cf['JS']['SWL_ALERT']);
define('JS_VUE', $cf['JS']['VUE']);

define('CREATE_DATE_AT', date_time('D')); // สร้างเมื่อวันที่
define('CREATE_TIME_AT', date_time('T')); // สร้างเมื่่อเวลา
define('CREATE_DT_AT', date_time('DT'));   // สร้างเมื่อวันที่ เเละเวลา

define('U_IP', $_SERVER['REMOTE_ADDR']);
define('U_IP_ADDR', ipAddr());

define('U_SYS_TOKEN', token_generator('CURD01'));

////////////////////////// REQUEST //////////////////////////

$request = anyRequest();

$http = new Http();



