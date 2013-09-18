<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 11/9/2556
 * Time: 12:13 น.
 * To change this template use File | Settings | File Templates.
 */

namespace DZApi;


use Httpful\Http;
use Httpful\Mime;
use Illuminate\Http\Request;

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
        $header = array();
        $method = strtolower($method);

        // if have token
        $token = (\Session::has('token'))? \Session::get('token'): false;
        if($token)
            $header["X-Auth-Token"] = $token;

        switch ($method)
        {
            case "post":
                $httpFul = \Httpful\Request::post($this->host.$url, $data, \Httpful\Mime::FORM);
                break;

            case "put":
                $httpFul = \Httpful\Request::put($this->host.$url, $data, \Httpful\Mime::FORM);
                break;

            case "delete":
                $httpFul = \Httpful\Request::delete($this->host.$url);
                break;

            default:
                if (!is_null($data))
                    $url = sprintf("%s?%s", $url, http_build_query($data));

                $httpFul = \Httpful\Request::get($this->host.$url);
                break;
        }

        $httpFul->addHeaders($header);
        $response = $httpFul->send();

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