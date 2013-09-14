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
    protected $host = 'http://localhost:8001';
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

        switch ($method)
        {
            case "post":
                curl_setopt($curl, CURLOPT_POST, 1);

                if (!is_null($data))
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "put":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if (!is_null($data))
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        $header = array();

        // test token
        $token = "eyJpdiI6IkpYaktYTW9xYXVCUEpPeTE1bVJBcTYreXRCQ3c1OTBERXhPNXhIWHNHbmM9IiwidmFsdWUiOiJ6VGx5bnJoUHlYODlrYUdNTzJQQVE4SmNkTlJYMzd1STh6aXpBQ3pVUEJcLzZNTnUzcDE4SHhcL25iKzExWHpoSHFmOGpwSmd3NFVUVklmTmplVmlIaFdNYjJXbmpXRDlFTDR0Z0pweU9aT1dOZmsybUhCTnk0M2RcL3AzV3daMnZOam8zSFVBdzdzWjU3V2M3WVlUSTNKRXRiVk5rU2NjbldyNzQxMzZQQXV1Rk09IiwibWFjIjoiNmNkY2M5MDhhMTBjOTFjZjk3MTYyYTJhMTM3MjQ1OThiNjQ5NzI3ODU5YjljNDllY2ZkMWI0MTViNDA2NDQ5NSJ9";
        $header[] = "X-Auth-Token: ".$token;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt($curl, CURLOPT_URL, $this->host.$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);

        return json_decode($response);
    }
}