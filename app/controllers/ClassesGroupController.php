<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 12/9/2556
 * Time: 16:32 น.
 * To change this template use File | Settings | File Templates.
 */

class ClassesGroupController extends BaseController {
    public function getIndex($class_id)
    {
        $classed = DZApi::instance()->call('get', '/class/'.$class_id);
        $groups = DZApi::instance()->call('get', '/class/'.$class_id.'/group');

        $this->layout->title = 'Group Manager';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Join us" => URL::to('joinus'),
                "Class" => URL::to('class'),
                $classed->name => URL::to("class/{$class_id}/group")
            ),
            'add'=> URL::to("class/{$class_id}/group/create")
        ));
        $this->layout->menu = 'joinus';
        $this->layout->content = View::make('classes/groups/index', array('classed'=> $classed, 'groups'=> $groups->data));
    }

    public function getDelete($class_id)
    {
        $response = DZApi::instance()->call('delete', "/class/{$class_id}/group/".Input::get('id'));
        return Response::json($response);
    }

    public function getCreate($class_id)
    {
        $classed = DZApi::instance()->call('get', '/class/'.$class_id);

        $this->layout->title = 'Create Group';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Join us" => URL::to('joinus'),
                "Class" => URL::to('class'),
                $classed->name => URL::to("class/{$class_id}/group")
            ),
            'add'=> URL::to("class/{$class_id}/group/create")
        ));
        $this->layout->menu = 'joinus';
        $this->layout->content = View::make('classes/groups/create/index');
        $this->layout->content->header = "Create Group";
    }

    public function postCreate($class_id)
    {
        $varView = array('post'=> $_POST);
        $uploads = null;

        if(Input::hasFile('video')){
            $tmp = new UploadTemp(Input::file("video"));
            $uploads = array('video'=> $tmp->getRealPath());
        }

        $response = DZApi::instance()->call("post", "/class/{$class_id}/group", $_POST, $uploads);
        if(isset($tmp))
            $tmp->deleteTemp();

        if(!isset($response->error))
        {
            return Redirect::to("class/{$class_id}/group");
        }
        $varView['error_message'] = $response->error->message;

        $this->layout->title = 'Create Group';

        $classed = DZApi::instance()->call('get', '/class/'.$class_id);
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Join us" => URL::to('joinus'),
                "Class" => URL::to('class'),
                $classed->name => URL::to("class/{$class_id}/group")
            ),
            'add'=> URL::to("class/{$class_id}/group/create")
        ));
        $this->layout->menu = 'joinus';
        $this->layout->content = View::make('classes/groups/create/index', $varView);
        $this->layout->content->header = "Create Group";
    }

    public function getEdit($class_id, $group_id)
    {
        $classed = DZApi::instance()->call('get', '/class/'.$class_id.'/group/'.$group_id);

        $this->layout->title = 'Create Group';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Join us" => URL::to('joinus'),
                "Class" => URL::to('class'),
                $classed->name => URL::to("class/{$class_id}/group")
            ),
            'add'=> URL::to("class/{$class_id}/group/create")
        ));
        $this->layout->menu = 'joinus';
        $this->layout->content = View::make('classes/groups/create/index', array(
            'post'=> json_decode(json_encode($classed), true)
        ));
        $this->layout->content->header = "Edit Group";
        $this->layout->content->oldData = $classed;
    }

    public function postEdit($class_id, $group_id)
    {
        $post = $_POST;
        $varView = array('post'=> $post);
        $uploads = null;

        try {
            $res = DZApi::instance()->call("put", "/class/{$class_id}/group/{$group_id}", $post);
            if(isset($res->error)){
                throw new Exception($res->error->message);
            }

            if(Input::hasFile('video')){
                $tmp = new UploadTemp(Input::file("video"));
                $res = DZApi::instance()->call("post", "/class/{$class_id}/group/{$group_id}/editVideo", null, array("video"=> $tmp->getRealPath()));
                $tmp->deleteTemp();

                if(isset($res->error))
                {
                    throw new Exception($res->error->message);
                }
            }

            return Redirect::to("/class/{$class_id}/group");
        }
        catch (Exception $e) {
            $varView['error_message'] = $e->getMessage();

            $this->layout->title = "Edit Group";
            $class = DZApi::instance()->call('get', "/class/{$class_id}");
            $this->layout->header = View::make('layouts/header', array(
                'breadcrumbs'=> array(
                    "Join us" => URL::to('joinus'),
                    'Class' => URL::to('class'),
                    $class->name => URL::to("class/{$class_id}/chapter"),
                ),
                'add'=> URL::to("class/{$class_id}/group/create")
            ));
            $classed = DZApi::instance()->call('get', '/class/'.$class_id.'/group/'.$group_id);

            $this->layout->menu = 'joinus';
            $this->layout->content = View::make('classes/groups/create/index', $varView);
            $this->layout->content->oldData = $classed;
            $this->layout->content->header = "Edit Group";
        }
    }
}