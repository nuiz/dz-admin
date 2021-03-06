<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 20/9/2556
 * Time: 12:44 น.
 * To change this template use File | Settings | File Templates.
 */

class ShowcaseController extends BaseController {
    public function getIndex()
    {
        $this->layout->title = 'Showcase';
        $this->layout->header = View::make('layouts/header', array(
            "breadcrumbs"=> array(
                'Showcase'=> URL::to("showcase")
            ),
            "add"=> "javascript:clickAdd();"
        ));
        $this->layout->menu = "showcase";

        $showcases = DZApi::instance()->call('get', '/showcase?fields=like,comment');
        $this->layout->content = View::make('showcases/index', array('showcases'=> $showcases->data));
    }

    public function getCreate()
    {
        $this->layout->title = 'Showcase';
        $this->layout->header = View::make('layouts/header', array(
            "breadcrumbs"=> array(
                'Showcase'=> URL::to("showcase")
            ),
            "add"=> "javascript:clickAdd();"
        ));
        $this->layout->menu = "showcase";
        $this->layout->content = View::make('showcases/create/index');
        $this->layout->content->header = "Create showcase";
    }

    public function postCreate(){
        $json = DZApi::instance()->call('post', "/showcase", Input::all());
        if(!isset($json->error)){
            return Redirect::to("showcase");
        }
        $this->layout->title = 'Showcase';
        $this->layout->header = View::make('layouts/header', array(
            "breadcrumbs"=> array(
                'Showcase'=> URL::to("showcase")
            ),
            "add"=> "javascript:clickAdd();"
        ));
        $this->layout->menu = "showcase";
        $this->layout->content = View::make('showcases/create/index');
        $this->layout->content->header = "Create showcase";
        $this->layout->content->post = Input::all();
        $this->layout->content->error_message = $json->error->message;
    }

    public function getDelete($id)
    {
        $res = DZApi::instance()->call('delete', '/showcase/'.$id);
        return Response::json($res);
    }

    public function postSort()
    {
        $res = DZApi::instance()->call('post', "/showcase/sort", Input::all());
        return Response::json($res);
    }
}