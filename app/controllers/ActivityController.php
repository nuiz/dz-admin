<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 20/9/2556
 * Time: 15:15 น.
 * To change this template use File | Settings | File Templates.
 */

class ActivityController extends BaseController {
    public function getIndex()
    {
        $this->layout->title = 'Activity';
        $this->layout->header = View::make('activities/header');

        $res = DZApi::instance()->call('get', '/activity');
        $this->layout->content = View::make('activities/index', array('activities'=> $res->data));
    }

    public function getCreate()
    {
        $this->layout->title = 'Create activity';
        $this->layout->header = 'Create activity';

        $this->layout->content = View::make('activities/create/index');
    }

    public function postCreate()
    {
        $post = Input::all();
        $varView = array('post'=> $post);
        $uploads = null;

        if(Input::hasFile('picture')){
            $picFile = Input::file('picture');
            $upload_name = str_replace('.', '', microtime(true)).'.'.$picFile->getClientOriginalExtension();
            $picFile->move('upload_tmp', $upload_name);
            chmod("upload_tmp/".$upload_name, "0777");

            $uploads = array('picture'=> realPath("upload_tmp/".$upload_name));
        }

        $res = DZApi::instance()->call('post', '/activity', $post, $uploads);
        if(!isset($res->error)){
            return Redirect::to('activity');
        }
        $varView['error_message'] = $res->error->message;

        $this->layout->title = 'Create activity';
        $this->layout->header = 'Create activity';

        $this->layout->content = View::make('activities/create/index', $varView);
    }

    public function getDelete($id)
    {
        $res = DZApi::instance()->call('delete', '/activity/'.$id);
        return Response::json($res);
    }

    /*
    public function getEdit($id)
    {

    }
    */

    public function postEdit($id)
    {
        $res = DZApi::instance()->call('update', '/activity/'.$id, Input::all());
        return Response::json($res);
    }
}