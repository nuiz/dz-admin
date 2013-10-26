<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 17/9/2556
 * Time: 12:53 น.
 * To change this template use File | Settings | File Templates.
 */

class TestController extends Controller {
    public function getIndex()
    {
        $apiURL = "https://www.googleapis.com/youtube/v3/videos?id=6gbT_I_BSSA&key=AIzaSyA1reRMMGfDbsiJzqUvXWaNgQrmGdaCAk8&part=snippet,contentDetails,statistics";

        $options = array(
            CURLOPT_URL  => $apiURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 5 );

        # connect api server through cURL
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        # execute cURL
        $json = curl_exec($ch) or die( curl_errno($ch)." ".curl_error($ch) );
        # close cURL connect
        curl_close($ch);

        # decode json encoded data
        $data = json_decode($json);

        $fnDuration = (function($isoTime){
            $itv = new DateInterval($isoTime);
            return ($itv->y * 365 * 24 * 60 * 60) +
            ($itv->m * 30 * 24 * 60 * 60) +
            ($itv->d * 24 * 60 * 60) +
            ($itv->h * 60 * 60) +
            ($itv->i * 60) +
            $itv->s;
        });

        return $fnDuration($data->items[0]->contentDetails->duration);
        return Response::json($data);
    }

    public function getDate()
    {
        $view = View::make("layouts/main");
        $view->header = <<<HTML
<a class="open-time">click</a>
<input name="mode8" id="mode8" type="text" data-role="datebox" data-options='{"mode":"durationflipbox", "useNewStyle":true}' />
<script type="text/javascript">
$(function(){
    $('.open-time').click(function(e){
        var a = $('<input type="date">');
        a.click();
        $('.datetime-test').blur();
    });
});
</script>
HTML;
        $view->title = "test";
        return $view;
    }
}