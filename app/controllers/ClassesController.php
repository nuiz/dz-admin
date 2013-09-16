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
        $this->layout->title = 'Class';
        $this->layout->header = 'Class';

        $classes = DZApi::instance()->call('get', '/class');
        $this->layout->content = View::make('classes/index', array('classes'=> $classes->data));
    }

    public function getCreate()
    {
        $this->layout->title = 'Create Class';
        $this->layout->header = View::make('classes/header');
        $this->layout->content = View::make('classes/create');
    }

    public function postCreate()
    {
        $variables = array();
        $variables['post'] = $_POST;

        $response = DZApi::instance()->call('post', '/class', $_POST);
        if(!isset($response->error)){
            return Redirect::to('class');
        }
        $variables['error'] = $response->error->message;
        $this->layout->title = 'Create Class';
        $this->layout->header = View::make('classes/header');

        $this->layout->content = View::make('classes/create', $variables);
    }
}