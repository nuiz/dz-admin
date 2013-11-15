<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 5/11/2556
 * Time: 11:33 น.
 * To change this template use File | Settings | File Templates.
 */

class StudyController extends BaseController {
    public function postEdit($id){
        $json = DZApi::instance()->call("put", "/study/{$id}", $_POST);
        return Response::json($json);
    }

    public function postCreate($group_id){
        $json = DZApi::instance()->call("post", "/group/{$group_id}/study", $_POST);
        return Response::json($json);
    }
}