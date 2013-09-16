<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 10/9/2556
 * Time: 17:21 น.
 * To change this template use File | Settings | File Templates.
 */


class UserController extends BaseController {

    public function getIndex()
    {
        $this->layout->title = 'User Manager';
        $this->layout->header = 'User Manager';

        $users = DZApi::instance()->call('get', '/user');
        $this->layout->content = View::make('users/index', array('users'=> $users->data));
    }

    public function postUpgrade($id)
    {
        $response = DZApi::instance()->call('put', '/user/'.$id, array(
            'type'=> 'member'));

        return Response::json($response);
    }
}