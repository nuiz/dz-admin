<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 20/9/2556
 * Time: 15:15 น.
 * To change this template use File | Settings | File Templates.
 */

class LessonController extends BaseController {
    public function getIndex()
    {
        $this->layout->title = 'Lesson';
        $this->layout->header = View::make('lessons/header');

        $res = DZApi::instance()->call('get', 'lesson');
    }
}