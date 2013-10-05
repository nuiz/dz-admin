<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 12/9/2556
 * Time: 16:32 น.
 * To change this template use File | Settings | File Templates.
 */

class ClassesGroupController extends BaseController {
    public function getIndex($class_id)
    {
        $classed = DZApi::instance()->call('get', '/class/'.$class_id);
        $groups = DZApi::instance()->call('get', '/class/'.$class_id.'/group');

        $this->layout->title = 'Group Manager';
        $this->layout->header = View::make('classes/groups/header', array('classed'=> $classed));
        $this->layout->content = View::make('classes/groups/index', array('classed'=> $classed, 'groups'=> $groups->data));
        $this->layout->menu = "class";
    }

    public function getDelete($class_id)
    {
        $response = DZApi::instance()->call('delete', "/class/{$class_id}/group/".Input::get('id'));
        return Response::json($response);
    }

    public function getCreate($class_id)
    {
        $classed = DZApi::instance()->call('get', '/class/'.$class_id);

        $this->layout->title = 'Create Group';
        $this->layout->header = 'Create Group';
        $this->layout->content = View::make('classes/groups/create/index');
        $this->layout->menu = "class";
    }

    public function postCreate($class_id)
    {
        $post = Input::all();
        if(isset($post['picture'])){
            unset($post['picture']);
        }
        $varView = array('post'=> $post);
        $uploads = null;

        if(Input::hasFile('picture')){
            $picFile = Input::file('picture');
            $upload_name = str_replace('.', '', microtime(true)).'.'.$picFile->getClientOriginalExtension();
            $picFile->move('upload_tmp', $upload_name);
            chmod("upload_tmp/".$upload_name, "0777");

            $uploads = array('picture'=> realPath("upload_tmp/".$upload_name));
        }

        $response = DZApi::instance()->call("post", "/class/{$class_id}/group", $_POST, $uploads);
        if(isset($bufferName))
            @unlink('upload_tmp/'.$bufferName);

        if(!isset($response->error))
        {
            return Redirect::to("class/{$class_id}/group");
        }
        $varView['error_message'] = $response->error->message;

        $this->layout->title = 'Create Group';
        $this->layout->header = 'Create Group';
        $this->layout->menu = "class";

        $this->layout->content = View::make('classes/groups/create/index', $varView);
    }
}