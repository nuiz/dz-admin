<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 17/9/2556
 * Time: 12:53 น.
 * To change this template use File | Settings | File Templates.
 */

class TestController extends Controller {
    public function getIndex()
    {
        $res = DZApi::instance()->call('put', '/test/1', array('a'=> 2, 'b'=> '4sss'));
        return Response::json($res);
    }

    public function putIndex()
    {

    }
}