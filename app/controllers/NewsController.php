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

        DZApi::instance()->setXDebugSession('PHPSTORM_DZ_SERVICE');
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
        $upload = null;
        $realpath = '';
        try {
            if(Input::hasFile('picture')){
                $picture = Input::file('picture');
                $upload_name = str_replace('.', '', microtime(true)).'.'.$picture->getClientOriginalExtension();
                $picture->move('upload_tmp', $upload_name);
                $realpath = realpath('upload_tmp/'.$upload_name);
                $upload = array('picture'=> $realpath);
                chmod('upload_tmp/'.$upload_name, 0777);
            }
            $post = Input::all();
            if(isset($post['picture'])){
                unset($post['picture']);
            }
            $res = DZApi::instance()->call('post', '/news', $post, $upload);
            if(!is_null($upload)){
                @unlink($realpath);
            }
            if(!isset($res->error)){
                return Redirect::to('news');
            }
            $this->layout->title = 'Create news';
            $this->layout->header = 'Create news';
            $this->layout->content = View::make('news/create/index', array('attr'=> $post, 'error'=> $res->error->message));
        }
        catch (Exception $e) {
            @unlink('upload_tmp/'.$upload_name);
            throw $e;
        }
    }

    public function getDelete($id)
    {
        DZApi::instance()->setXDebugSession('PHPSTORM_DZ_SERVICE');
        $news = DZApi::instance()->call('delete', '/news/'.$id);

        return Response::json($news);
    }
}
