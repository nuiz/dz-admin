<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 10/9/2556
 * Time: 17:05 น.
 * To change this template use File | Settings | File Templates.
 */

class NewsController extends BaseController {
    public function getIndex()
    {
        $this->layout->title = "News";
        $this->layout->header = View::make('news/header');

        $news = DZApi::instance()->call('get', '/news');
        $this->layout->content = View::make('news/index', array('news'=> $news->data));
    }

    public function getCreate()
    {
        $this->layout->title = 'Create news';
        $this->layout->header = 'Create news';
        $this->layout->content = View::make('news/create/index');
    }

    public function postCreate()
    {
        $res = DZApi::instance()->call('post', '/news', Input::all());
        if(!isset($res->error)){
            return Redirect::to('news');
        }
        $this->layout->title = 'Create news';
        $this->layout->header = 'Create news';
        $this->layout->content = View::make('news/create/index', array('attr'=> Input::all()));
    }
}