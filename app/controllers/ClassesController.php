<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 16/9/2556
 * Time: 9:39 น.
 * To change this template use File | Settings | File Templates.
 */

class ClassesController extends BaseController {
    public function getIndex()
    {
        $this->layout->title = 'Classes';
        $this->layout->header = 'Classes';

        $classes = DZApi::instance()->call('get', '/classes');
        $this->layout->content = View::make('classes/index', array('classes'=> $classes->data));
    }
}