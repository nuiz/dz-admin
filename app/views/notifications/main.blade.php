<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 10/10/2556
 * Time: 14:31 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<div style="background: white; height: 100%;">
    <ul class="nav nav-pills nav-stacked col-xs-4" style="padding: 0;">
        <li class="n-button reg-upgrade active"><a href="{{ URL::to('notification/regupgrade') }}">Upgrade Request <span class="badge pull-right"><?php if($count_nf->register_upgrade > 0){ echo $count_nf->register_upgrade; } ?></span></a></li>
        <li class="n-button reg-group"><a href="{{ URL::to('notification/reggroup') }}">Group Request <span class="badge pull-right"><?php if($count_nf->register_group > 0){ echo $count_nf->register_group; } ?></span></a></li>
        <li class="n-button user-activity"><a href="{{ URL::to('notification/useractivity') }}">Join Activity <span class="badge pull-right"><?php if($count_nf->user_activity > 0){ echo $count_nf->user_activity; } ?></span></a></li>
        <li class="n-button send-message hidden"><a href="{{ URL::to('notification/sendmessage') }}">Send Message</a></li>
    </ul>
    <div class="col-xs-8 notification-content" style="position: relative; min-height: 200px; overflow-y: scroll; height: 100%;">
        @yield('content')
    </div>
<div>
<script type="text/javascript">
$(function(){
    var xhr = false;
    $('.n-button').bind('click touchstart', function(e){
        e.preventDefault();
        var href = $("a", this).attr("href");

        var loadingIcon = $('<img class="loading-container" src="<?php echo URL::to("img/ajax-loader.gif"); ?>">');
        $('.notification-content').html('');
        $('.notification-content').append(loadingIcon);

        if(typeof xhr.abort == 'function')
            xhr.abort();

        xhr = $.ajax({
            url: href,
            success: function(data) {
                $('.notification-content').html(data);
                xhr = false;
            }
        });

        $('.n-button').removeClass('active');
        $(this).addClass('active');

        $(".badge", this).text("");
    });
    $('.n-button.active').click();

    $('.create-message').click(function(e){
        e.preventDefault();
        $('.send-message').click();
    });
});
</script>