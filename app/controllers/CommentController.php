<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 8/11/2556
 * Time: 16:44 น.
 * To change this template use File | Settings | File Templates.
 */

class CommentController extends BaseController {
    public function postDelete($id){
        return Response::json(DZApi::instance()->call("delete", "/comment/{$id}"));
    }
}