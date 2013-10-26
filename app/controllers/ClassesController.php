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
        $this->layout->title = 'all class';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                'Class'=> URL::to('class')
            ),
            'add'=> URL::to('class/create')
        ));
        $this->layout->menu = 'class';

        $classes = DZApi::instance()->call('get', '/class');
        $this->layout->content = View::make('classes/index', array('classes'=> $classes->data));
    }

    public function getCreate()
    {
        $this->layout->title = 'Create Class';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                'Class'=> URL::to('class')
            ),
            'add'=> URL::to('class/create')
        ));
        $this->layout->content = View::make('classes/create/index');
        $this->layout->content->headForm = "Create Class";
        $this->layout->menu = "class";
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
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                'Class'=> URL::to('class')
            ),
            'add'=> URL::to('class/create')
        ));

        $this->layout->content = View::make('classes/create/index', $variables);
        $this->layout->content->headForm = 'Create Class';
        $this->layout->menu = "class";
    }

    public function getEdit($class_id){
        $classed = DZApi::instance()->call('get', "/class/{$class_id}");
        if(DZApi::instance()->isEmptyOrNotFound($classed)){
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('not found class');
        }
        $this->layout->title = 'Edit Class';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                'Class'=> URL::to('class')
            ),
            'add'=> URL::to('class/create')
        ));
        $this->layout->content = View::make('classes/create/index');
        $this->layout->content->post = $classed;
        $this->layout->content->oldData = $classed;
        $this->layout->content->headForm = 'Edit Class';
        $this->layout->menu = "class";
    }

    public function postEdit($class_id){
        $res = DZApi::instance()->call('put', "/class/{$class_id}", Input::all());
        if(!isset($res->error)){
            Return Redirect::to('class');
        }
        $this->layout->title = 'Edit Class';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                'Class'=> URL::to('class')
            ),
            'add'=> URL::to('class/create')
        ));
        $this->layout->content = View::make('classes/create/index');
        $this->layout->content->post = Input::all();
        $this->layout->content->headForm = 'Edit Class';

        $classed = DZApi::instance()->call('get', "/class/{$class_id}");
        $this->layout->content->oldData = $classed;
        $this->layout->menu = "class";
    }

    public function getDelete()
    {
        $response = DZApi::instance()->call('delete', "/class/".Input::get('id'));
        return Response::json($response);
    }
}