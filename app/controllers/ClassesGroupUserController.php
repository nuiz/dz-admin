<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 16/9/2556
 * Time: 16:01 น.
 * To change this template use File | Settings | File Templates.
 */

class ClassesGroupUserController extends BaseController {
    public function getIndex($class_id, $group_id)
    {
        $classed = DZApi::instance()->call('get', "/class/{$class_id}");
        $group = DZApi::instance()->call('get', "/class/{$class_id}/group/{$group_id}");

        $result = DZApi::instance()->call('get', "/class/{$class_id}/group/{$group_id}/user", array('import'=> 'false'));

        $this->layout->menu = "class";
        $this->layout->title = 'Class >> Group >> User';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "class" => URL::to('class'),
                $classed->name => URL::to("class/{$class_id}/group"),
                $group->name => URL::to("class/{$class_id}/group/{$group_id}/user")
            ),
            'add'=> URL::to("class/{$class_id}/group/{$group_id}/user/import")
        ));
        $this->layout->content = View::make('classes/groups/users/index', array(
            'users'=> $result->data,
            'classed'=> $classed,
            'group'=> $group
        ));
    }

    public function getImport($class_id, $group_id)
    {
        $classed = DZApi::instance()->call('get', "/class/{$class_id}");
        $group = DZApi::instance()->call('get', "/class/{$class_id}/group/{$group_id}");

        $this->layout->menu = "class";
        $this->layout->title = 'Class >> Group >> Import user';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "class" => URL::to('class'),
                $classed->name => URL::to("class/{$class_id}/group"),
                $group->name => URL::to("class/{$class_id}/group/{$group_id}/user")
            ),
            'add'=> URL::to("class/{$class_id}/group/{$group_id}/user/import")
        ));

        $users = DZApi::instance()->call('get', "/class/{$class_id}/group/{$group_id}/user", array("import"=> "true"));
        $this->layout->content = View::make('classes/groups/users/imports/index', array(
            'users'=> $users->data,
            'classed'=> $classed,
            'group'=> $group
        ));
    }

    public function postImport($class_id, $group_id, $user_id)
    {
        $response = DZApi::instance()->call('post', "/class/{$class_id}/group/{$group_id}/user", array('user_id'=> $user_id));
        return Response::json($response);
    }

    public function getRemove($class_id, $group_id, $user_id)
    {
        $response = DZApi::instance()->call('delete', "/class/{$class_id}/group/{$group_id}/user/{$user_id}");
        return Response::json($response);
    }
}