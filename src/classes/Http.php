<?php

/**
 * @author PUG <email@email.com>
 */

class EnumHttpStatus
{
    const DELETE  = 'DELETE';
    const GET     = 'GET';
    const HEAD    = 'HEAD';
    const OPTIONS = 'OPTIONS';
    const PATCH   = 'PATCH';
    const POST    = 'POST';
    const PUT     = 'PUT';

    const OK              = 200;
    const CLIENT_ERROR    = 400;
    const SERVER_ERROR    = 500;
}

class Http extends EnumHttpStatus
{
    private $allowHeaders = [];
    private static $setHeader = [];

    /**
     * Set Request Headers
     *
     * @param array $headers
     * @return void
     */
    public static function setHeaders(array $headers = [])
    {
        self::$setHeader = $headers;
    }

    /**
     * POST Request
     *
     * @param string $post_url
     * @param array $post_data
     * @return mixed
     */
    public static function post(string $post_url, array $post_data)
    {
        $response = self::request($post_url, 'POST', $post_data);
        return self::getResponse($response);
    }

    /**
     * GET Request
     *
     * @param string $get_url
     * @return mixed
     */
    public static function get($get_url, $callback = null)
    {
        $response = self::request($get_url, 'GET');
        $result = self::getResponse($response);

        if (is_callable($callback)) return $callback($result);
        return self::getResponse($response);
    }

    /**
     * Process Request
     *
     * @param string $url
     * @param string $method
     * @param array|null $data
     * @return mixed
     */
    private static function request(string $url, string $method, array $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::$setHeader);

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * Process Response
     *
     * @param string $response
     * @return mixed
     */
    private static function getResponse(string $response)
    {
        if (!$response) {
            return null;
        }

        $decoded_response = json_decode($response, true);
        if (!$decoded_response) {
            return $response;
        }

        return $decoded_response;
    }

    /**
     * @param string $allow_req
     * @param boolean $toArray
     * @return mixed
     */
    public static function requestFromClient($allow_req = '_REQUEST_')
    {
        if ($allow_req === '_REQUEST_') {
            $request = $_REQUEST;
        } else {
            $request = [];
            switch (strtoupper($allow_req)) {
                case 'GET':
                    $request = $_GET;
                    break;
                case 'POST':
                    $request = $_POST;
                    break;
                case 'PUT':
                    parse_str(file_get_contents('php://input'), $request);
                    break;
                case 'ALLOW':
                    $request = json_decode(file_get_contents('php://input'), true);
                    break;
            }
        }

        return $request;
    }

    /**
     * @param string $allow_method
     * @return mixed
     */
    public function getBody($allow_method = ''): mixed
    {   
        if (strtoupper($allow_method) === "allow") return $_REQUEST;
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * @param array $data_to_resp
     * @return void
     */
    public static function responseToClient($data_to_resp)
    {
        if (isset($data_to_resp[0])) {
            echo json_encode($data_to_resp, JSON_PRETTY_PRINT);
            http_response_code(200);
            exit;
        } else {
            echo json_encode([$data_to_resp], JSON_PRETTY_PRINT);
            http_response_code(200);
            exit;
        }
    }

    /**
     * @param string $str_method
     * @return bool
     */
    public function allowMethod($str_method = '')
    {
        return $_SERVER['REQUEST_METHOD'] == strtoupper($str_method);
    }

    /**
     * @return void
     */
    public function response404()
    {
        // header("HTTP/1.1 500 Internal Server Error");
        header("HTTP/1.0 404 Not Found");
        http_response_code(404);
        exit;
    }

    /**
     * @param string $data
     * @return string
     */
    public function input($data)
    {
        if ($data != '') {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        return '';
    }

    /**
     * @param string $headers
     * @return self
     */
    public function headers($headers)
    {
        if (is_string($headers)) {
            $i = 0;
            $this->allowHeaders[] = $headers;
            foreach ($this->allowHeaders as $access => $header) {
                if ($header !== '') {
                    header($header);
                    $i++;
                }
            }

            if ($i > 0) {
                return $this;
            }
            $this->allowHeaders[] = '';
            $this->response404();
            return $this;
        }
        $this->allowHeaders[] = '';
        return $this;
    }
}

// $get_response = $http::get("https://jsonplaceholder.typicode.com/posts/{$_GET['id']}");

// $http->responseToClient($get_response);

// $post_url = 'https://jsonplaceholder.typicode.com/posts';
// $post_data = [
//     'title' => 'foo11111111',
//     'body' => 'bar111111111111111111111111111',
//     'userId' => 1
// ];

// $post_response = Service::post($post_url, $post_data);

// $service->responseToClient($post_response);

// $service->headers('Access-Control-Allow-Origin: *')
//         ->headers('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS')
//         ->headers('Access-Control-Allow-Headers: *')
//         ->headers('Access-Control-Max-Age:', '86400')
//         ->headers('Content-type: application/json charset=utf-8');