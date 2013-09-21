<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 21/9/2556
 * Time: 11:02 น.
 * To change this template use File | Settings | File Templates.
 */

class LessonChapterVideoController extends BaseController {

    public function getIndex($lesson_id, $chapter_id)
    {
        $lesson = DZApi::instance()->call('get', "/lesson/{$lesson_id}");
        $chapter = DZApi::instance()->call('get', "/lesson/{$lesson_id}/chapter/{$chapter_id}");
        $videos = DZApi::instance()->call('get', "/lesson/{$lesson_id}/chapter/{$chapter_id}/video");

        $this->layout->title = "Lesson >> Chapter >> Video";
        $this->layout->header = View::make('lessons/chapters/videos/header', array('lesson'=> $lesson, 'chapter'=> $chapter));
        $this->layout->content = View::make('lessons/chapters/videos/index', array('videos'=> $videos->data, 'lesson'=> $lesson, 'chapter'=> $chapter));
    }

    public function getCreate($lesson_id, $chapter_id)
    {
        $this->layout->title = "Lesson >> Chapter >> Create Video";
        $this->layout->header = "Lesson >> Chapter >> Create Video";

        $this->layout->content = View::make('lessons/chapters/videos/create/index');
    }

    public function postCreate($lesson_id, $chapter_id)
    {
        try {
            @ini_set( 'upload_max_size' , '64M' );
            @ini_set( 'post_max_size', '64M');
            @ini_set( 'max_execution_time', '300' );

            $videoFile = Input::file('video');
            $ext = strtolower($videoFile->getClientOriginalExtension());
            $bufferName = str_replace('.', '', microtime(true)).'.'.$ext;
            $videoFile->move('upload_tmp', $bufferName);
            chmod('upload_tmp/'.$bufferName, 0777);
            $post = Input::all();
            unset($post['video']);

            $files = array('video'=> realpath('upload_tmp/'.$bufferName));
            $res = DZApi::instance()->call('post', "/lesson/{$lesson_id}/chapter/{$chapter_id}/video", $post, $files);

            if(!isset($res->error)){
                return Redirect::to("/lesson/{$lesson_id}/chapter/{$chapter_id}/video");
            }

            $this->layout->title = "Lesson >> Chapter >> Create Video";
            $this->layout->header = "Lesson >> Chapter >> Create Video";

            $this->layout->content = View::make('lessons/chapters/videos/create/index', array('post'=> $post, 'error_message'=> $res->error->message));
        }
        catch (Exception $e){
            if(isset($bufferName))
                @unlink('upload_tmp/'.$bufferName);
            throw $e;
        }
    }

    public function getDelete($lesson_id, $chapter_id, $id)
    {
        DZApi::instance()->setXDebugSession('PHPSTORM_DZ_SERVICE');
        $news = DZApi::instance()->call('delete', "/lesson/{$lesson_id}/chapter/{$chapter_id}/video/{$id}");

        return Response::json($news);
    }

    public function getEdit($lesson_id, $chapter_id, $id)
    {

    }

    public function postEdit($lesson_id, $chapter_id, $id)
    {

    }
}