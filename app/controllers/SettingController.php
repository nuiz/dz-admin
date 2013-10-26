<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 22/10/2556
 * Time: 15:44 น.
 * To change this template use File | Settings | File Templates.
 */

class SettingController extends Controller {
    public function getIndex(){
        $res = DZApi::instance()->call("get", "/setting");
        return Response::json($res);
    }

    public function postIndex(){
        $uploads = null;

        if(Input::hasFile('picture')){
            $picFile = Input::file('picture');
            $upload_name = str_replace('.', '', microtime(true)).'.'.$picFile->getClientOriginalExtension();
            $picFile->move('upload_tmp', $upload_name);
            chmod("upload_tmp/".$upload_name, "0777");

            $uploads = array('picture'=> realPath("upload_tmp/".$upload_name));
        }
        $resp = DZApi::instance()->call("post", "/setting", $_POST, $uploads);
        return Response::json($resp);
    }
}