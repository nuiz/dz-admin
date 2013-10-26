<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 10/9/2556
 * Time: 17:21 น.
 * To change this template use File | Settings | File Templates.
 */

class UserController extends BaseController {

    public function getIndex()
    {
        $this->layout->title = 'User Manager';
        $this->layout->header = View::make('layouts/header', array(
            "breadcrumbs"=> array(
                "User" => URL::to("user")
            )
        ));
        $this->layout->menu = "user";

        $users = DZApi::instance()->call('get', '/user?fields=groups');
        $this->layout->content = View::make('users/index', array('users'=> $users->data));
    }

    public function postUpgrade($id)
    {
        $str = "P";
        if(Input::get("year")>0){
            $str .= Input::get("year")."Y";
        }
        if(Input::get("month")>0){
            $str .= Input::get("month")."M";
        }
        if(Input::get("day")>0){
            $str .= Input::get("day")."D";
        }
        $date = new DateTime();
        $date->add(new DateInterval($str));
        $response = DZApi::instance()->call('put', '/user/'.$id, array(
            'type'=> 'member',
            'member_timeout'=> $date->format("Y-m-d")
        ));

        return Response::json($response);
    }

    public function getDelete($id)
    {
        $response = DZApi::instance()->call('delete', '/user/'.$id);
        return Response::json($response);
    }
}