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
        $this->layout->header = View::make('classes/groups/header', array('classed'=> $classed));
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
        $this->layout->header = 'Create Group';
        $this->layout->content = View::make('classes/groups/create/index', array('classed'=> $classed));
    }

    public function postCreate($class_id)
    {
        \DZApi\DZApi::instance()->setXDebugSession('PHPSTORM_DZ_SERVICE');
        $response = DZApi::instance()->call("post", "/class/{$class_id}/group", $_POST);
        if(!isset($response->error))
        {
            return Redirect::to("class/{$class_id}/group");
        }
        $this->layout->title = 'Create Group';
        $this->layout->header = 'Create Group';

        $classed = DZApi::instance()->call('get', '/class/'.$class_id);
        $this->layout->content = View::make('classes/groups/create/index', array('classed'=> $classed, 'error'=> $response->error->message, 'post'=> $_POST));
    }

    public function getEdit($class_id, $group_id)
    {
        $this->layout->title = 'Edit Group';
        $this->layout->header = 'Edit Group';

        $group = DZApi::instance()->call('get', "/class/{$class_id}/group/{$group_id}");
        $this->layout->content = View::make('classes/groups/create/index', array('post'=> $group));
    }
}