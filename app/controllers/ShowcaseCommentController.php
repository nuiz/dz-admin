<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 8/11/2556
 * Time: 17:03 น.
 * To change this template use File | Settings | File Templates.
 */

class ShowcaseCommentController extends BaseController {
    public function getIndex($showcase_id){
        $showcase = DZApi::instance()->call('get', '/showcase/'.$showcase_id);
        $comments = DZApi::instance()->call("get", "/dz_object/{$showcase_id}/comment");

        $this->layout->title = "Comment";
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Showcase" => URL::to('showcase'),
            ),
        ));

        $this->layout->menu = "showcase";
        $this->layout->content = View::make("showcases/comment/index");
        $this->layout->content->showcase = $showcase;
        $this->layout->content->comments = $comments->data;
    }
}