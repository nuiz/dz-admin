<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 11/9/2556
 * Time: 12:13 น.
 * To change this template use File | Settings | File Templates.
 */

namespace DZApi;


class DZApi {
    protected $host = 'http://localhost/dz-service';
    protected static $_instance = null;

    protected function __construct(){}

    public static function instance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DZApi();
        }
        return self::$_instance;
    }

    public function call($method, $url, $data=null)
    {
        $method = strtolower($method);
        $curl = curl_init();

        $header = array();
        $data_string = http_build_query($data);

        switch ($method)
        {
            case "post":
                curl_setopt($curl, CURLOPT_POST, 1);

                if (!is_null($data))
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;

            case "put":
                curl_setopt($curl, CURLOPT_PUT, 1);

                if(!is_null($data)){
                    $header[] = "Content-Type: application/x-www-form-urlencoded";
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                }
                break;

            case "delete":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;

            default:
                if (!is_null($data))
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                break;
        }

        // Optional Authentication:

        // token
        $token = (\Session::has('token'))? \Session::get('token'): false;
        if($token)
            $header[] = "X-Auth-Token: ".$token;

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt($curl, CURLOPT_URL, $this->host.$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);

        return json_decode($response);
    }

    public function setUser($user, $token)
    {
        \Session::put('DZApi.user', $user);
        \Session::put('DZApi.token', $token);
    }

    public function getUser()
    {
        return \Session::get('DZApi.user');
    }

    public function getToken()
    {
        return \Session::get('DZApi.token');
    }

    public function arrayToObject($d) {
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return (object) array_map(__FUNCTION__, $d);
        }
        else {
            // Return object
            return $d;
        }
    }

    public function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }
}