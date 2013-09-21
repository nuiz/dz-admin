<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 20/9/2556
 * Time: 15:15 น.
 * To change this template use File | Settings | File Templates.
 */

class LessonController extends BaseController {
    public function getIndex()
    {
        $this->layout->title = 'Lesson';
        $this->layout->header = View::make('lessons/header');

        $res = DZApi::instance()->call('get', '/lesson');
        $this->layout->content = View::make('lessons/index', array('lessons'=> $res->data));
    }

    public function getCreate()
    {
        $this->layout->title = 'Create lesson';
        $this->layout->header = 'Create lesson';

        $this->layout->content = View::make('lessons/create/index');
    }

    public function postCreate()
    {
        $res = DZApi::instance()->call('post', '/lesson', Input::all());
        if(!isset($res->error)){
            return Redirect::to('lesson');
        }

        $this->layout->title = 'Create lesson';
        $this->layout->header = 'Create lesson';

        $this->layout->content = View::make('lessons/create/index', array('post'=> Input::all(), 'error_message'=> $res->error->message));
    }

    public function getDelete($id)
    {
        $res = DZApi::instance()->call('delete', '/lesson/'.$id);
        return Response::json($res);
    }

    /*
    public function getEdit($id)
    {

    }
    */

    public function postEdit($id)
    {
        $res = DZApi::instance()->call('update', '/lesson/'.$id, Input::all());
        return Response::json($res);
    }
}