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
        $result = DZApi::instance()->call('get', '/class/'.$class_id.'/group');
        $groups = $result->data;

        $this->layout->title = 'Group Manager';
        $this->layout->header = 'Group Manager';
        $this->layout->content = View::make('classes/groups/index', array('classed'=> $classed,'groups'=> $groups));
    }

    public function getDelete($class_id)
    {
        $response = DZApi::instance()->call('delete', "/class/{$class_id}/group/".Input::get('id'));
        return Response::json($response);
    }
}