<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 20/9/2556
 * Time: 12:44 น.
 * To change this template use File | Settings | File Templates.
 */

class ShowcaseController extends BaseController {
    public function getIndex()
    {
        $this->layout->title = 'Showcase';
        $this->layout->header = View::make('showcases/header');
        $this->layout->menu = "showcase";

        $showcases = DZApi::instance()->call('get', '/showcase');
        $this->layout->content = View::make('showcases/index', array('showcases'=> $showcases->data));
    }

    public function postIndex()
    {
        preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', Input::get('youtube_id'), $matches);

        $error_message = false;
        if(!isset($matches[0])){
            $error_message = 'youtube link invalid';
        }
        else {
            $youtube_id = $matches[0];

            $attr = Input::all();
            $attr['youtube_id'] = $youtube_id;
            $res = DZApi::instance()->call('post', '/showcase', $attr);
            if(!isset($res->error)){
                return Redirect::refresh();
            }
            $error_message = $res->error->message;
        }

        $this->layout->menu = "showcase";
        $this->layout->title = 'Add Showcase';
        $this->layout->header = 'Add Showcase';
        $this->layout->content = View::make('showcases/create/index',
            array('post'=> Input::all(), 'error_message'=> $error_message));
    }

    public function getDelete($id)
    {
        $res = DZApi::instance()->call('delete', '/showcase/'.$id);
        return Response::json($res);
    }
}