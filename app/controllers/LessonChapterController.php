<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 21/9/2556
 * Time: 10:15 น.
 * To change this template use File | Settings | File Templates.
 */

class LessonChapterController extends BaseController {
    public function getIndex($lesson_id)
    {
        $lesson = DZApi::instance()->call('get', "/lesson/{$lesson_id}");
        $this->layout->title = 'Lesson >> Chapter';
        $this->layout->header = View::make('lessons/chapters/header', array('lesson'=> $lesson));

        $res = DZApi::instance()->call('get', "/lesson/{$lesson_id}/chapter");
        $this->layout->content = View::make('lessons/chapters/index', array('chapters'=> $res->data, 'lesson'=> $lesson));
    }

    public function getCreate($lesson_id)
    {
        //$lesson = DZApi::instance()->call('get', "/lesson/{$lesson_id}");
        $this->layout->title = 'Lesson >> Create Chapter';
        $this->layout->header = 'Lesson >> Create Chapter';

        $this->layout->content = View::make('lessons/chapters/create/index');
    }

    public function postCreate($lesson_id)
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
        $res = DZApi::instance()->call('post', "/lesson/{$lesson_id}/chapter", $post, $uploads);
        if(!isset($res->error)){
            return Redirect::to("/lesson/{$lesson_id}/chapter");
        }
        $varView['error_message'] = $res->error->message;

        $this->layout->title = 'Lesson >> Create Chapter';
        $this->layout->header = 'Lesson >> Create Chapter';

        $this->layout->content = View::make('lessons/chapters/create/index', $varView);
    }

    public function getDelete($lesson_id, $id)
    {
        $res = DZApi::instance()->call('delete', '/lesson/'.$lesson_id.'/chapter/'.$id);
        return Response::json($res);
    }
}