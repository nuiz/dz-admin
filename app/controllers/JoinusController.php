<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 2/11/2556
 * Time: 10:58 น.
 * To change this template use File | Settings | File Templates.
 */

class JoinusController extends BaseController {
    public function getIndex(){
        $this->layout->title = 'Join us';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Join us" => URL::to('joinus')
            )
        ));

        $res = DZApi::instance()->call("get", "/setting");
        $this->layout->menu = "joinus";
        $this->layout->content = View::make("layouts/join_us");
        $this->layout->content->menu = "joinus";
        $this->layout->content->content = View::make("joinus/main", array(
            "setting"=> $res
        ));
    }
}