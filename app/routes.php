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

Route::get('/', function()
{
	return View::make('login');
});

Route::post('/', function(){
    $auth = DZApi::instance()->call('post', '/auth', array(
        'username'=> $_POST['email'],
        'password'=> $_POST['password']
    ));

    if(!isset($auth->error)){
        DZApi::instance()->setUser($auth->user, $auth->token);
        return Redirect::action('UserController@getIndex');
    }

    return View::make('login');
});

Route::controller('news', 'NewsController');
Route::controller('user', 'UserController');
Route::controller('class', 'ClassesController');
Route::any('class/(id)/group', 'ClassesGroupController');