<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 16/10/2556
 * Time: 14:15 น.
 * To change this template use File | Settings | File Templates.
 */

class PopupController extends Controller {
    public function getUser($id){
        $user = DZApi::instance()->call("get", "/user/{$id}");
        if(isset($user->error)){
            print_r($user->error);
            return View::make("popups/not_found");
        }
        else{
            return View::make("popups/user", array('user'=> $user));
        }
    }

    public function getRegupgrade($id){
        $item = DZApi::instance()->call("get", "/register_upgrade/{$id}");
        if(isset($item->error)){
            return View::make("popups/not_found");
        }
        else{
            return View::make("popups/user_reg", array('item'=> $item));
        }
    }

    public function getReggroup($id){
        $item = DZApi::instance()->call("get", "/register_group/{$id}");
        if(isset($item->error)){
            return View::make("popups/not_found");
        }
        else{
            return View::make("popups/user_reg", array('item'=> $item));
        }
    }

    public function getUserActivity($id){

    }

    public function getUserGroup($id){

    }
}