<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 8/11/2556
 * Time: 14:49 น.
 * To change this template use File | Settings | File Templates.
 */

class NewsCommentController extends BaseController {
    public function getIndex($news_id){
        $news = DZApi::instance()->call('get', '/news/'.$news_id);
        $comments = DZApi::instance()->call("get", "/dz_object/{$news_id}/comment");

        $this->layout->title = "Comment";
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Update" => URL::to('news'),
            ),
        ));
        $this->layout->menu = "news";
        $this->layout->content = View::make("news/comment/index");
        $this->layout->content->news = $news;
        $this->layout->content->comments = $comments->data;
    }
}