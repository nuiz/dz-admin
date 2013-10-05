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
        $res = Response::json(array('a'=> 'b', 'c'=> 'd'));
        App::after(function($req, $res){
            echo PHP_EOL;
            echo 'asdasd';
        });
        $res->send();
    }
}