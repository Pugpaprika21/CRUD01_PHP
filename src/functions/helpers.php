<?php

////////////////////////////////////// FORM ////////////////////////////////////////

if (!function_exists('url_where')) {

    /**
     * @param string $path_url
     * @param array $query_str
     * @return string|void
     */
    function url_where($path_url = '', $query_str = array())
    {
        $params = "";
        if (count($query_str) > 0) $params = "?";

        if (file_exists($path_url)) return "{$path_url}{$params}" . http_build_query($query_str, '', '&');
        //header("HTTP/1.0 404 Not Found");
        throw new Exception("URL not found : {$path_url}", 1);
    }
}

////////////////////////////////////// REDIRECT ////////////////////////////////////////

if (!function_exists('redirect_to')) {

    /**
     * @param string $real_path
     * @param array $query_str_arr
     * @return void
     */
    function redirect_to(string $real_path, array $query_str_arr = []): void
    {
        $file_type = '.php';
        $check_path = $real_path . $file_type;
        $query_str = http_build_query($query_str_arr);

        if (file_exists($check_path)) {
            $path = $real_path . '.php';
            if (count($query_str_arr) > 0) {
                $path .= '?' . $query_str;
            }
            header("location: {$path}");
            exit();
        } else {
            $message = "The file {$check_path} does not exist.";
            echo "<script> alert('$message'); </script>";
            http_response_code(500);
            exit();
        }
    }
}

////////////////////////////////////// DISPLAY ////////////////////////////////////////

if (!function_exists('echo_r')) {
    /**
     * @param null $param
     * @param boolean $exist
     * @return void
     */
    function echo_r($param = null, $exist = true)
    {
        $data = print_r($param, true);
        echo sprintf("<pre><div id='debug-data' data-id='{$data}' style='padding: 10px; color: #FFFFFF; background-color: #000000;'>%s</div></pre>", $data);
        if ($exist) exit;
    }
}

////////////////////////////////////// Token ////////////////////////////////////////

if (!function_exists('token_generator')) {

    /**
     * #token_generator();
     *
     * @param string $salt
     * @return void
     */
    function token_generator($salt = "example_salt")
    {
        $token = uniqid();
        $token = hash("sha256", $token . $salt . time());
        return $token;
    }
}


////////////////////////////////////// CSRF ////////////////////////////////////////

if (!function_exists('str')) {
    /**
     * @param string $data
     * @return string
     */
    function str(string $data = ""): string
    {
        $data = strip_tags($data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        /* 
        // $pattern = '/[^a-zA-Z0-9ก-๙เแ]/u'; 
                // return preg_replace($pattern, '', $data);
        */
    }
}

/////////////////////////////////////////// DATE_TIME ////////////////////////////////////////

if (!function_exists('date_time')) {

    /**
     * @param string $time_zone -> D = DATE, T = TIME, F = DATE AND TIME
     * @return string
     */
    function date_time($format_date_as_time = 'F')
    {
        $formatted_date_time = '';
        switch (strtoupper($format_date_as_time)) {
            case 'D':
                $formatted_date_time = date('Y-m-d');
                break;
            case 'T':
                $formatted_date_time = date('H:i:s', time());
                break;
            default:
                $formatted_date_time = date('Y-m-d') . ' ' . date('H:i:s', time());
                break;
        }
        return $formatted_date_time;
    }
}

if (!function_exists('dt_th')) {

    /**
     * format data '2023-04-06 18:43:07';
     *
     * @param string $datetime
     * @return void
     */
    function dt_th($datetime)
    {
        $months = array(
            'มกราคม',
            'กุมภาพันธ์',
            'มีนาคม',
            'เมษายน',
            'พฤษภาคม',
            'มิถุนายน',
            'กรกฎาคม',
            'สิงหาคม',
            'กันยายน',
            'ตุลาคม',
            'พฤศจิกายน',
            'ธันวาคม'
        );

        $datetime = strtotime($datetime);
        $day = date('j', $datetime);
        $month = date('n', $datetime);
        $year = date('Y', $datetime) + 543;
        $hour = date('H', $datetime);
        $minute = date('i', $datetime);
        $second = date('s', $datetime);

        $month = $months[$month - 1];

        return "$day $month $year เวลา $hour:$minute:$second น.";
    }
}

/////////////////////////////////////////// USER IP; ////////////////////////////////////////

if (!function_exists('ipAddr')) {

    function ipAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

if (!function_exists('write_log')) {

    /**
     * #write_log("oooo", "../logs/process/insert_user.txt");
     * 
     * @param string $message
     * @param string $file
     * @param bool $stop_write
     * @return mixed
     */
    function write_log($message, $file = 'log.txt', $stop_write = false)
    {
        if ($stop_write == false) return;

        $log = function () use ($message, $file) {
            $time = date_time('DT');
            $log = "[$time] $message\n";
            return file_put_contents($file, $log, FILE_APPEND | LOCK_EX);
        };

        if (file_exists($file)) {
            $log();
            return;
        } else {
            $log();
            return;
        }
        throw new Exception("Write log error : {$file}");
    }
}

///////////////////////// REQUEST /////////////////////

if (!function_exists('anyRequest')) {

    function anyRequest() {
        return array(
            'POST' => $_POST,
            'GET' => $_GET,
            'FILES' => $_FILES,
            'ANY' =>  $_REQUEST,
            'CLIENT' => json_decode(file_get_contents('php://input'), true)
        );
    }
}