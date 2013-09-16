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
        $result = DZApi::instance()->call('get', "/class/{$class_id}/group/{$group_id}/user");
        $this->layout->title = 'Class >> Group >> User';
        $this->layout->header = 'Class >> Group >> User';
        $this->layout->content = View::make('classes/groups/users/index', array('users'=> $result->data));
    }
}