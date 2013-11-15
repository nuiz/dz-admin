<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 8/11/2556
 * Time: 14:49 น.
 * To change this template use File | Settings | File Templates.
 */

class ActivityCommentController extends BaseController {
    public function getIndex($activity_id){
        $activity = DZApi::instance()->call('get', '/activity/'.$activity_id);
        $comments = DZApi::instance()->call("get", "/dz_object/{$activity_id}/comment");

        $this->layout->title = "Comment";
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Activity" => URL::to('activity'),
            ),
        ));
        $this->layout->menu = "activity";
        $this->layout->content = View::make("activities/comment/index");
        $this->layout->content->activity = $activity;
        $this->layout->content->comments = $comments->data;
    }
}