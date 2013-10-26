<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 10/10/2556
 * Time: 14:30 น.
 * To change this template use File | Settings | File Templates.
 */

class NotificationController extends Controller {
    public function getIndex(){
        $view = View::make("notifications/main");
        $count_nf = DZApi::instance()->call("get", "/count_notification");
        $view->count_nf = $count_nf;
        return $view;
    }

    public function getRegupgrade(){
        $view = View::make("notifications/register_upgrade");
        $json = DZApi::instance()->call("get", "/register_upgrade");
        $view->items = $json->data;
        return $view;
    }

    public function getReggroup(){
        $view = View::make("notifications/register_group");
        $json = DZApi::instance()->call("get", "/register_group");
        $view->items = $json->data;
        return $view;
    }

    public function getUseractivity(){
        $view = View::make("notifications/user_activity");
        $json = DZApi::instance()->call("get", "/user_activity");
        $view->items = $json->data;
        return $view;
    }

    public function getRead(){
        if($_GET['type'] == "register_upgrade"){
            $json = DZApi::instance()->call("get", "/register_upgrade/read_all");
            return Response::json($json);
        }
        else if($_GET['type'] == "register_group"){
            $json = DZApi::instance()->call("get", "/register_group/read_all");
            return Response::json($json);
        }
        else if($_GET['type'] == "user_activity"){
            $json = DZApi::instance()->call("get", "/user_activity/read_all");
            return Response::json($json);
        }
    }

    public function getSendmessage()
    {
        //$classes = DZApi::instance()->call("get", "/class?field=groups");

        $classes = DZApi::instance()->call("get", "/class");
        $groups = DZApi::instance()->call("get", "/group?fields=class");
        $activities = DZApi::instance()->call("get", "/activity");
        $users = DZApi::instance()->call("get", "/user");

        $view = View::make("notifications/send_message");
        $view->classes = $classes;
        $view->groups = $groups;
        $view->activities = $activities;
        $view->users = $users;
        return $view;
    }

    public function postSend()
    {
        return Response::json(DZApi::instance()->call("post", "/sys_notification", Input::all()));
    }

    public function getCount()
    {
        return Response::json(DZApi::instance()->call("get", "/count_notification"));
    }

    public function getAdminNf()
    {
        return Response::json(DZApi::instance()->call("get", "/admin_notification"));
    }

    public function getList($object_id)
    {
        $notifications = DZApi::instance()->call("get", "/sys_notification/{$object_id}");
    }

    public function getAll($type)
    {
        $notifications = DZApi::instance()->call("get", "/sys_notification");
    }

    public function postEditregup($id)
    {
        $res = DZApi::instance()->call("put", "/register_upgrade/{$id}", Input::all());
        return Response::json($res);
    }

    public function postEditreggroup($id)
    {
        $res = DZApi::instance()->call("put", "/register_group/{$id}", Input::all());
        return Response::json($res);
    }
}