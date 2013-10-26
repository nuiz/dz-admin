<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 20/9/2556
 * Time: 15:15 น.
 * To change this template use File | Settings | File Templates.
 */

class ActivityController extends BaseController {
    public function getIndex()
    {
        $this->layout->title = 'Activity';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Activity" => URL::to('activity')
            ),
            'add'=> URL::to("activity/create")
        ));

        $res = DZApi::instance()->call('get', '/activity');
        $this->layout->content = View::make('activities/index', array('activities'=> $res->data));
        $this->layout->menu = "activity";
    }

    public function getCreate()
    {
        $this->layout->title = 'Create Activity';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Activity" => URL::to('activity')
            ),
            'add'=> URL::to("activity/create")
        ));

        $this->layout->content = View::make('activities/create/index');
        $this->layout->content->header = "Create Activity";
        $this->layout->menu = "activity";
    }

    public function postCreate()
    {
        $varView = array('post'=> $_POST);
        $uploads = null;

        if(Input::hasFile('picture')){
            $tmp = new UploadTemp(Input::file('picture'));
            $uploads = array('picture'=> realPath($tmp->getRealPath()));
        }

        $res = DZApi::instance()->call('post', '/activity', $_POST, $uploads);
        if(!isset($res->error)){
            return Redirect::to('activity');
        }
        $varView['error_message'] = $res->error->message;

        $this->layout->title = 'Create Activity';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Activity" => URL::to('activity')
            ),
            'add'=> URL::to("activity/create")
        ));

        $this->layout->content = View::make('activities/create/index', $varView);
        $this->layout->content->header = "Create Activity";
        $this->layout->menu = "activity";

        if(isset($tmp)){
            $tmp->deleteTemp();
        }
    }

    public function getDelete($id)
    {
        $res = DZApi::instance()->call('delete', '/activity/'.$id);
        return Response::json($res);
    }

    public function getEdit($id)
    {
        $res = DZApi::instance()->call("get", "/activity/".$id);
        $post = json_decode(json_encode($res), true);

        $this->layout->title = 'Create Activity';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Activity" => URL::to('activity')
            ),
            'add'=> URL::to("activity/create")
        ));

        $this->layout->content = View::make('activities/create/index');
        $this->layout->content->post = $post;
        $this->layout->content->oldData = $res;
        $this->layout->content->header = "Edit Activity";
        $this->layout->menu = "activity";

    }

    public function postEdit($id)
    {
        try {
            $res = DZApi::instance()->call("put", "/activity/{$id}", $_POST);
            if(isset($res->error)){
                throw new Exception($res->error->message);
            }
            if(Input::hasFile("picture")){
                $tmp = new UploadTemp(Input::file('picture'));
                $res = DZApi::instance()->call("post", "/activity/{$id}/editPicture", null, array("picture"=> $tmp->getRealPath()));
                if(isset($res->error)){
                    throw new Exception($res->error->message);
                }
            }
            return Redirect::to("/activity");
        }
        catch (Exception $e) {
            $this->layout->title = 'Edit Activity';
            $this->layout->header = View::make('layouts/header', array(
                'breadcrumbs'=> array(
                    "activity" => URL::to('activity')
                ),
                'add'=> URL::to("activity/create")
            ));
            $this->layout->content = View::make('activities/create/index', array('post'=> $_POST, "error_message"=> $e->getMessage()));
            $this->layout->content->header = "Edit Activity";

            $oldData = DZApi::instance()->call("get", "/activity/".$id);
            $this->layout->content->oldData = $oldData;
            $this->layout->menu = "activity";
        }
    }
}