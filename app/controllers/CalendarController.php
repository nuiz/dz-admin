<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 4/11/2556
 * Time: 16:51 น.
 * To change this template use File | Settings | File Templates.
 */

class CalendarController extends BaseController {
    public function getIndex(){
        $groups = DZApi::instance()->call("get", "/group?fields=class");
        $groups = json_decode(json_encode($groups), true);

        $this->layout->title = 'Calendar';
        $this->layout->header = View::make('layouts/header', array(
            'breadcrumbs'=> array(
                "Join us" => URL::to('joinus'),
                "Calendar" => URL::to('class'),
            ),
            'add'=> URL::to("calendar/create")
        ));
        $this->layout->menu = 'joinus';
        $this->layout->content = View::make('calendars/main');
        $this->layout->content->groups = $groups['data'];
    }

    public function getData(){
        $json = DZApi::instance()->call("get", "/admin_calendar");
        return Response::json($json);
    }
}