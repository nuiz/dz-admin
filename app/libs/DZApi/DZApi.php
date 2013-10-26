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
use Illuminate\Support\Facades\Redirect;

class DZApi {
    protected $host = 'http://61.19.147.72/api';
    protected $xdebug_session = false;
    protected $last_response = null;
    protected static $_instance = null;

    protected function __construct(){}

    public static function instance(){
        if(is_null(self::$_instance)){
            self::$_instance = new DZApi();
        }
        return self::$_instance;
    }

    public function call($method, $url, $data=null, $files=null)
    {
        $header = array();
        $method = strtolower($method);

        // if have token
        $token = $this->getToken();
        if($token)
            $header["X-Auth-Token"] = $token;

        switch ($method)
        {
            case "post":
                $httpFul = \Httpful\Request::post($this->host.$url, $data, \Httpful\Mime::FORM);
                if(!is_null($files)){
                    $httpFul->sendsType(\Httpful\Mime::UPLOAD);
                    $httpFul->attach($files);
                }
                break;

            case "put":
                $httpFul = \Httpful\Request::put($this->host.$url, $data, \Httpful\Mime::FORM);
                break;

            case "delete":
                if(!is_null($data))
                    $url = sprintf("%s?%s", $url, http_build_query($data));

                $httpFul = \Httpful\Request::delete($this->host.$url);
                break;

            default:
                if (!is_null($data))
                    $url = sprintf("%s?%s", $url, http_build_query($data));

                $httpFul = \Httpful\Request::get($this->host.$url);
                break;
        }

        if($this->xdebug_session!=false || true)
        {
            $this->xdebug_session = 'PHPSTORM_DZ_SERVICE';
            //$header['Cookie'] = "XDEBUG_SESSION=".$this->xdebug_session;
        }
        $httpFul->addHeaders($header);
        $this->last_response = $response = $httpFul->send();

        $data = json_decode($response);

        if(isset($data->error)){
            if($data->error->type=="Tappleby\\AuthToken\\Exceptions\\NotAuthorizedException"){
                $this->clearUser();
                echo "<h1>มีเข้าใช้งานจากอุปกรณ์อื่น</h1>";
                echo Redirect::to('/');
            }
        }
        return $data;
    }

    public function get_last_response()
    {
        return $this->last_response;
    }

    public function setXDebugSession($xdebug_session)
    {
        // PHPSTORM_DZ_SERVICE
        $this->xdebug_session = $xdebug_session;
    }

    public function setUser($user, $token)
    {
        \Session::put('DZApi.user', $user);
        \Session::put('DZApi.token', $token);
    }

    public function clearUser()
    {
        \Session::remove('DZApi.user');
        \Session::remove('DZApi.token');
    }

    public function getUser()
    {
        return \Session::get('DZApi.user');
    }

    public function getToken()
    {
        return \Session::get('DZApi.token');
    }

    public function isEmpty($object)
    {
        return count((array)$object)==0;
    }

    public function isNotfound($object)
    {
        if(isset($object->error)){
            if(isset($object->error->type)){
                return $object->error->type == "Illuminate\\Database\\Eloquent\\ModelNotFoundException";
            }
        }
        return false;
    }

    public function isEmptyOrNotFound($obj)
    {
        return $this->isEmpty($obj)
            || $this->isNotfound($obj);
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