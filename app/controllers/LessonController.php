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
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Lesson" => URL::to('lesson')
            ),
            'add'=> URL::to("lesson/create")
        ));
        $this->layout->menu = "lesson";

        $res = DZApi::instance()->call('get', '/lesson');
        $this->layout->content = View::make('lessons/index', array('lessons'=> $res->data));
    }

    public function getCreate()
    {
        $this->layout->title = 'Create Lesson';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Lesson" => URL::to('lesson')
            ),
            'add'=> URL::to("lesson/create")
        ));
        $this->layout->menu = "lesson";

        $this->layout->content = View::make('lessons/create/index');
        $this->layout->content->header = "Create Lesson";
    }

    public function postCreate()
    {
        $res = DZApi::instance()->call('post', '/lesson', Input::all());
        if(!isset($res->error)){
            return Redirect::to('lesson');
        }

        $this->layout->title = 'Create Lesson';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Lesson" => URL::to('lesson')
            ),
            'add'=> URL::to("lesson/create")
        ));
        $this->layout->menu = "lesson";

        $this->layout->content = View::make('lessons/create/index', array('post'=> Input::all(), 'error_message'=> $res->error->message));
        $this->layout->content->header = "Create Lesson";
    }

    public function getDelete($id)
    {
        $res = DZApi::instance()->call('delete', '/lesson/'.$id);
        return Response::json($res);
    }


    public function getEdit($id)
    {
        $res = DZApi::instance()->call("get", "/lesson/{$id}");

        $this->layout->title = 'Edit Lesson';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Lesson" => URL::to('lesson')
            ),
            'add'=> URL::to("lesson/create")
        ));
        $this->layout->menu = "lesson";

        $this->layout->content = View::make('lessons/create/index', array('post'=> json_decode(json_encode($res), true)));
        $this->layout->content->header = "Edit Lesson";
        $this->layout->content->oldData = $res;
    }

    public function postEdit($id)
    {
        $res = DZApi::instance()->call('put', '/lesson/'.$id, $_POST);
        if(!isset($res->error->message)){
            return Redirect::to("lesson");
        }

        $varView = array('post'=> json_decode(json_encode($res)));
        $varView['error_message'] = $res->message->error;

        $this->layout->title = 'Edit Lesson';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Lesson" => URL::to('lesson')
            ),
            'add'=> URL::to("lesson/create")
        ));
        $this->layout->menu = "lesson";

        $this->layout->content = View::make('lessons/create/index', $varView);
        $this->layout->content->header = "Edit Lesson";

        $data = $res = DZApi::instance()->call("get", "/lesson/{$id}");
        $this->layout->content->oldData = $data;
    }

    public function postSort()
    {
        $res = DZApi::instance()->call('post', "/lesson/sort", Input::all());
        return Response::json($res);
    }
}