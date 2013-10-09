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
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "news" => URL::to('news'),
            ),
            'add'=> URL::to("news/create")
        ));
        $this->layout->menu = "news";

        $news = DZApi::instance()->call('get', '/news');
        $this->layout->content = View::make('news/index', array('news'=> $news->data));
    }

    public function getCreate()
    {
        $this->layout->title = 'Create News';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "news" => URL::to('news'),
            ),
            'add'=> URL::to("news/create")
        ));
        $this->layout->content = View::make('news/create/index');
        $this->layout->content->header = "Create News";
        $this->layout->menu = "news";
    }

    public function postCreate()
    {
        $upload = null;
        $realpath = '';
        try {
            if(Input::hasFile('media')){
                $picture = Input::file('media');
                $upload_name = str_replace('.', '', microtime(true)).'.'.$picture->getClientOriginalExtension();
                $picture->move('upload_tmp', $upload_name);
                $realpath = realpath('upload_tmp/'.$upload_name);
                $upload = array('media'=> $realpath);
                chmod('upload_tmp/'.$upload_name, 0777);
            }
            $post = Input::all();
            if(isset($post['media'])){
                unset($post['media']);
            }
            $res = DZApi::instance()->call('post', '/news', $post, $upload);
            if(!is_null($upload)){
                @unlink($realpath);
            }
            if(!isset($res->error)){
                return Redirect::to('news');
            }
            $this->layout->menu = "news";
            $this->layout->title = 'Create News';
            $this->layout->header = View::make('layouts/header', array(
                'breadcrumbs'=> array(
                    "news" => URL::to('news'),
                ),
                'add'=> URL::to("news/create")
            ));
            $this->layout->content = View::make('news/create/index', array('attr'=> $post, 'error'=> $res->error->message));
            $this->layput->content->header = "Create News";
        }
        catch (Exception $e) {
            if(isset($upload_name))
                @unlink('upload_tmp/'.$upload_name);
            throw $e;
        }
    }

    public function getEdit($id)
    {
        $newsData = DZApi::instance()->call("get", "/news/{$id}");
        $this->layout->title = 'Edit news';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "news" => URL::to('news'),
            ),
            'add'=> URL::to("news/create")
        ));
        $this->layout->content = View::make('news/create/index', array('post'=> json_decode(json_encode($newsData), true)));
        $this->layout->content->header = "Edit News";
        $this->layout->menu = "news";
    }

    public function postEdit($id)
    {
        try {
            $res = DZApi::instance()->call("put", "/news/{$id}", $_POST);
            if(isset($res->error)){
                throw new Exception($res->error->message);
            }
            if(Input::hasFile("media")){
                $tmp = new UploadTemp(Input::file('media'));
                $res = DZApi::instance()->call("post", "/news/{$id}/editMedia", null, array("media"=> $tmp->getRealPath()));
                if(isset($res->error)){
                    throw new Exception($res->error->message);
                }
            }
            return Redirect::to('news');
        }
        catch (Exception $e) {
            $this->layout->title = 'Edit news';
            $this->layout->header = View::make('layouts/header', array(
                'breadcrumbs'=> array(
                    "news" => URL::to('news'),
                ),
                'add'=> URL::to("news/create")
            ));
            $this->layout->content = View::make('news/create/index', array('post'=> $_POST, "error_message"=> $e->getMessage()));
            $this->layout->content->header = "Edit News";
            $this->layout->menu = "news";
        }
        if(isset($tmp)){
            $tmp->deleteTemp();
        }
    }

    public function getDelete($id)
    {
        $news = DZApi::instance()->call('delete', '/news/'.$id);

        return Response::json($news);
    }
}
