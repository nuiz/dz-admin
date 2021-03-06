<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

App::missing(function($exception)
{
    return Response::view('errors.missing', array(), 404);
});

App::error(function(\OAuthException $e){
    DZApi::instance()->clearUser();
    return Redirect::to('/');
});

Route::get('/', function()
{
	return View::make('login');
});

Route::post('/', function(){
    //DZApi::instance()->setXDebugSession('PHPSTORM_DZ_SERVICE');
    $auth = DZApi::instance()->call('post', '/auth', array(
        'username'=> $_POST['email'],
        'password'=> $_POST['password']
    ));

    if(!isset($auth->error)){
        DZApi::instance()->setUser($auth->user, $auth->token);
        return Redirect::action('NewsController@getIndex');
    }

    return View::make('login');
});

Route::get('logout', function(){
    DZApi::instance()->clearUser();
    return Redirect::to("/");
});

Route::controller('test', 'TestController');

Route::controller("news/{news_id}/comment", "NewsCommentController");
Route::controller('news', 'NewsController');

Route::controller('user', 'UserController');

Route::controller("showcase/{showcase_id}/comment", "ShowcaseCommentController");
Route::controller('showcase', 'ShowcaseController');

Route::controller('lesson/{lesson_id}/chapter/{chapter_id}/video', 'LessonChapterVideoController');
Route::controller('lesson/{lesson_id}/chapter', 'LessonChapterController');
Route::controller('lesson', 'LessonController');

Route::controller('class/{class_id}/group/{group_id}/user', 'ClassesGroupUserController');
Route::controller('class/{class_id}/group', 'ClassesGroupController');
Route::controller('class', 'ClassesController');

Route::controller("activity/{activity_id}/comment", "ActivityCommentController");
Route::controller('activity', 'ActivityController');

Route::controller('notification', 'NotificationController');

Route::controller("popup", "PopupController");
Route::controller('setting', "SettingController");
Route::controller('joinus', "JoinusController");

Route::controller('calendar', "CalendarController");
Route::controller('study', "StudyController");

Route::post("change_password", function(){
    $res = DZApi::instance()->call("post", "/user/1/change_password", Input::all());
    return Response::json($res);
});

Route::controller("comment", "CommentController");