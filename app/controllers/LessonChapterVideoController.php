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

        $this->layout->menu = "lesson";
        $this->layout->title = "Video";
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                'lesson' => URL::to('lesson'),
                $lesson->name => URL::to("lesson/{$lesson_id}/chapter"),
                $chapter->name => URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video")
            ),
            'add'=> URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video/create")
        ));
        $this->layout->content = View::make('lessons/chapters/videos/index', array('videos'=> $videos->data, 'lesson'=> $lesson, 'chapter'=> $chapter));
    }

    public function getCreate($lesson_id, $chapter_id)
    {
        $this->layout->title = "Create Video";
        $lesson = DZApi::instance()->call('get', "/lesson/{$lesson_id}");
        $chapter = DZApi::instance()->call('get', "/lesson/{$lesson_id}/chapter/{$chapter_id}");
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                'lesson' => URL::to('lesson'),
                $lesson->name => URL::to("lesson/{$lesson_id}/chapter"),
                $chapter->name => URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video")
            ),
            'add'=> URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video/create")
        ));
        $this->layout->menu = "lesson";

        $this->layout->content = View::make('lessons/chapters/videos/create/index');
        $this->layout->content->header = "Create Video";
    }

    public function postCreate($lesson_id, $chapter_id)
    {
        try {
            @ini_set( 'upload_max_size' , '64M' );
            @ini_set( 'post_max_size', '64M');
            @ini_set( 'max_execution_time', '300' );

            $varView = array();
            $post = $_POST;

            $varView['post'] = $post;
            if(Input::hasFile('video')){
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
                $varView['error_message'] = $res->error->message;
            }
            else {
                $varView['error_message'] = 'require file video upload';
            }

            $this->layout->title = "Create Video";
            $lesson = DZApi::instance()->call('get', "/lesson/{$lesson_id}");
            $chapter = DZApi::instance()->call('get', "/lesson/{$lesson_id}/chapter/{$chapter_id}");
            $this->layout->header = View::make('layouts/header', array(
                'breadcrumbs'=> array(
                    'lesson' => URL::to('lesson'),
                    $lesson->name => URL::to("lesson/{$lesson_id}/chapter"),
                    $chapter->name => URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video")
                ),
                'add'=> URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video/create")
            ));
            $this->layout->menu = "lesson";

            $this->layout->content = View::make('lessons/chapters/videos/create/index', $varView);
            $this->layout->content->header = "Create Video";
        }
        catch (Exception $e){
            if(isset($bufferName))
                @unlink('upload_tmp/'.$bufferName);
            throw $e;
        }
    }

    public function getDelete($lesson_id, $chapter_id, $id)
    {
        $res = DZApi::instance()->call('delete', "/lesson/{$lesson_id}/chapter/{$chapter_id}/video/{$id}");
        return Response::json($res);
    }

    public function getEdit($lesson_id, $chapter_id, $id)
    {
        $res = DZApi::instance()->call('get', "/lesson/{$lesson_id}/chapter/{$chapter_id}/video/{$id}");

        $varView['post'] = json_decode(json_encode($res), true);

        $this->layout->title = "Edit Video";
        $lesson = DZApi::instance()->call('get', "/lesson/{$lesson_id}");
        $chapter = DZApi::instance()->call('get', "/lesson/{$lesson_id}/chapter/{$chapter_id}");
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                'lesson' => URL::to('lesson'),
                $lesson->name => URL::to("lesson/{$lesson_id}/chapter"),
                $chapter->name => URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video")
            ),
            'add'=> URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video/create")
        ));
        $this->layout->menu = "lesson";

        $this->layout->content = View::make('lessons/chapters/videos/create/index', $varView);
        $this->layout->content->header = "Edit Video";
    }

    public function postEdit($lesson_id, $chapter_id, $id)
    {
        $post = $_POST;
        $varView = array('post'=> $post);
        $uploads = null;

        try {
            $res = DZApi::instance()->call("put", "/lesson/{$lesson_id}/chapter/{$chapter_id}/video/{$id}", $post);
            if(isset($res->error)){
                throw new Exception($res->error->message);
            }

            if(Input::hasFile('video')){
                $tmp = new UploadTemp(Input::file("video"));
                $res = DZApi::instance()->call("post", "/lesson/{$lesson_id}/chapter/{$chapter_id}/video/{$id}/editVideo", null, array("video"=> $tmp->getRealPath()));
            }

            if(isset($res->error))
            {
                throw new Exception($res->error->message);
            }

            return Redirect::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video");
        }
        catch (Exception $e) {
            $varView['error_message'] = $e->getMessage();

            $this->layout->title = "Edit Video";
            $lesson = DZApi::instance()->call('get', "/lesson/{$lesson_id}");
            $chapter = DZApi::instance()->call('get', "/lesson/{$lesson_id}/chapter/{$chapter_id}");
            $this->layout->header = View::make('layouts/header', array(
                'breadcrumbs'=> array(
                    'lesson' => URL::to('lesson'),
                    $lesson->name => URL::to("lesson/{$lesson_id}/chapter"),
                    $chapter->name => URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video")
                ),
                'add'=> URL::to("lesson/{$lesson_id}/chapter/{$chapter_id}/video/create")
            ));
            $this->layout->menu = "lesson";

            $this->layout->content = View::make('lessons/chapters/videos/create/index', $varView);
            $this->layout->content->header = "Edit Video";
        }
    }
}