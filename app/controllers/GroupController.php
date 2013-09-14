<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 12/9/2556
 * Time: 16:32 น.
 * To change this template use File | Settings | File Templates.
 */

class GroupController extends BaseController {
    public function getIndex()
    {
        $groups = DZApi::instance()->call('get', '/group');

        $this->layout->header = 'Group Manager';
        $this->layout->content = View::make('groups/index', array('groups'=> $groups));
    }
}