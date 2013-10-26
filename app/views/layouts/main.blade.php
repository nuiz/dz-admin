<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 10/9/2556
 * Time: 11:54 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>admin - {{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!-- Bootstrap -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="//code.jquery.com/jquery.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="{{ URL::asset('fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>

    <link rel="stylesheet" href="{{ URL::asset('fancybox/source/jquery.fancybox.css') }}" type="text/css" media="screen" />
    <script type="text/javascript" src="{{ URL::asset('fancybox/source/jquery.fancybox.pack.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('js/DZApi.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('html5lightbox/html5lightbox.js') }}"></script>


    <![endif]-->

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <!--<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.mobile.min.css') }}>-->
</head>
<body>

<div class="wrap">
    <div class="container">
        <div class="header">
            {{ $header }}
        </div>
        <div class="main-body">
            @yield('content')
        </div>
        <div class="main-nav">
            <a class="mainnav-btn @if(@$menu=='news'){{ 'active' }}@endif" href="<?php echo URL::to('news');?>">Update</a>
            <a class="mainnav-btn @if(@$menu=='showcase'){{ 'active' }}@endif" href="<?php echo URL::to('showcase');?>">Showcase</a>
            <a class="mainnav-btn @if(@$menu=='lesson'){{ 'active' }}@endif" href="<?php echo URL::to('lesson');?>">Lesson</a>
            <a class="mainnav-btn @if(@$menu=='activity'){{ 'active' }}@endif" href="<?php echo URL::to('activity');?>">Activity</a>
            <a class="mainnav-btn @if(@$menu=='class'){{ 'active' }}@endif" href="<?php echo URL::to('class');?>">Class & Group</a>
            <a class="mainnav-btn @if(@$menu=='user'){{ 'active' }}@endif" href="<?php echo URL::to('user');?>">User</a>
        </div>
    </div>
    <div class="notification-container">
        <div class="header">
            <a href="" class="glyphicon glyphicon-plus-sign create-message add-on-header"></a>
            <a href="" class="glyphicon glyphicon-remove notification-close"></a>
            Notification
        </div>
        <div class="notification-body"></div>
    </div>
    <div class="setting-container">
        <div class="header">
            <a href="" class="glyphicon glyphicon-remove setting-close"></a>
            Setting
        </div>
        <div class="setting-body" style="overflow: auto;">
            <div class="setting-in-body" style="background: white; padding: 20px 0;">
                <form class="form form-setting" style="margin: 0 auto; width: 500px;">
                    <legend>Data Application</legend>
                    <div class="form-group setting-field-media">
                        <input type="file" class="form-control setting-media" name="picture">
                    </div>
                    <div class="form-group">
                        <label>phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>email</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>line</label>
                        <input type="text" name="line" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>facebook</label>
                        <input type="text" name="facebook" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>twitter</label>
                        <input type="text" name="twitter" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>youtube</label>
                        <input type="text" name="youtube" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>website</label>
                        <input type="text" name="website" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary pull-left" value="Done">
                        <input type="button" class="btn btn-primary pull-right setting-cancel" value="Reset">
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.setting-container {
    position: absolute;
    right: -100%;
}
</style>
<script type="text/javascript">
var IS_IOS = /iphone|ipad/i.test(navigator.userAgent);

$.fn.nodoubletapzoom = function() {
if (IS_IOS)
    $(this).bind('touchstart', function preventZoom(e) {
        var t2 = e.timeStamp
            , t1 = $(this).data('lastTouch') || t2
            , dt = t2 - t1
            , fingers = e.originalEvent.touches.length;
        $(this).data('lastTouch', t2);
        if (!dt || dt > 500 || fingers > 1) return; // not double-tap

        e.preventDefault(); // double tap - prevent the zoom
        // also synthesize click events we just swallowed up
        $(this).trigger('click').trigger('click');
    });
};

$(function(){
    function setBodySize(){
        var allH = $(window).height();
        //var contentH = allH-88;
        $('.main-body').height(window.innerHeight-88);
        $('.notification-body').height(window.innerHeight-44);
        $('.setting-body').height(window.innerHeight-44);
        window.scrollTo(0,0);
        //$('.main-body').height(contentH);
    }
    setBodySize();

    window.onorientationchange = setBodySize;
});

$(function(){
    var nfContext = $('.notification-container');
    var stContext = $('.setting-container');
    var nfLoaded = false;

    function openNotification()
    {
        if(window.location.hash != "#notification"){
            window.location.hash = "#notification";
        }
        nfContext.css({ left: 0 });
        if(!nfLoaded){
            nfLoaded = true;
            var loadingIcon = $('<img class="loading-container" src="<?php echo URL::to("img/ajax-loader.gif"); ?>">');
            $('.notification-body', nfContext).append(loadingIcon);
            window.location.href = '#notification';
            //setTimeout(function(){
            $('.notification-body', nfContext).load("<?php echo URL::to("notification"); ?>");
            //}, 300);
        }
    }

    function closeNotification()
    {
        nfContext.css({ left: "" });
        if(window.location.hash == "#notification"){
            window.location.hash = "";
        }
    }

    <?php if($menu=='user'){ ?>
    (function(){
        var oldData = {};
        var sending = false;
        var inputName = $('#input-name');
        var inputMessage = $('#input-message');
        $('.cancle-button').click(function(e){
            e.preventDefault();
            if(oldData==null){
                inputName.val("");
                inputMessage.val("");
            }
            else {
                inputName.val(oldData.name);
                inputMessage.val(oldData.message);
                $('.media-block').html('').append(oldMedia);
                $('.field-media').show();
            }
        });

        var settingButton = $('<a href="" class="glyphicon glyphicon-cog setting-button"></a>');
        $('.container .header').append(settingButton);

        var formSetting = $('.form-setting');
        formSetting.hide();
        var loadingSettingIcon = $('<img class="loading-container" src="<?php echo URL::to("img/ajax-loader.gif"); ?>">');
        $('.setting-body .setting-in-body', stContext).append(loadingSettingIcon);

        $('.setting-field-media', formSetting).delegate('.setting-reupload-media', 'click', function(e){
            e.preventDefault();
            if(sending)
                return;
            $('.setting-field-media').html(
                '<label>picture</label>' +
                '<input type="file" class="form-control setting-media" name="picture">');
        });

        function setData(data){
            $('input[type="text"][name="phone"]', formSetting).val(data.phone);
            $('input[type="text"][name="email"]', formSetting).val(data.email);
            $('input[type="text"][name="line"]', formSetting).val(data.line);
            $('input[type="text"][name="facebook"]', formSetting).val(data.facebook);
            $('input[type="text"][name="twitter"]', formSetting).val(data.twitter);
            $('input[type="text"][name="youtube"]', formSetting).val(data.youtube);
            $('input[type="text"][name="website"]', formSetting).val(data.website);

            if(typeof data.picture != "undefined" && data.picture.link != $('.setting-picture').attr('src')){
                var oldMedia = $('.setting-field-media', formSetting).html(
                    '<a href="" class="setting-reupload-media">upload ใหม่</a>' +
                    '<img src="'+data.picture.link+'" class="setting-picture" style="max-width: 100%;">'
                );
            }
        }
        $.get("<?php echo URL::to("setting"); ?>", function(data){
            formSetting.show();
            loadingSettingIcon.remove();
            setData(data);
            oldData = data;
        }, "json");

        $('.setting-cancel', formSetting).click(function(e){
            setData(oldData);
        });

        $(formSetting).submit(function(e){
            e.preventDefault();
            if(sending){
                return;
            }
            sending = true;
            var serilizeData = formSetting.serializeArray();
            $('input', formSetting).prop('disabled', true);
            var data = {};
            var fd = new FormData();
            for(var key in serilizeData){
                fd.append(serilizeData[key].name, serilizeData[key].value);
            }

            var PicInput = $('input[name="picture"]', formSetting);
            if(PicInput.size() > 0 && PicInput[0].files.length > 0){
                fd.append("picture", PicInput[0].files[0]);
            }

            $.ajax({
                url: "<?php echo URL::to("setting"); ?>",
                type: "POST",
                dataType: "json",
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    sending = false;
                    $('input', formSetting).prop('disabled', false);
                    if(typeof data.error != "undefined"){
                        alert(data.error.message);
                        return;
                    }
                    setData(data);
                    oldData = data;
                },
                error: function(jqXHR, textStatus, errorMessage) {
                    console.log(errorMessage); // Optional
                }
            });
        });
    }());
    <?php } ?>

    function openSetting(){
        if(window.location.hash != "#setting"){
            window.location.hash = "#setting";
        }
        stContext.css({ right: 0 });
    }

    function closeSetting(){
        if(window.location.hash == "#setting"){
            window.location.hash = "";
        }
        stContext.css({ right: "" });
    }

    window.onpopstate = function(event) {
        if(window.location.hash == "#notification"){
            closeSetting();
            openNotification();
        }
        else if(window.location.hash == "#setting"){
            closeNotification();
            openSetting();
        }
        else {
            closeNotification();
            closeSetting();
        }
    };

    $('.notification-button').bind('click touchstart', function(e){
        e.preventDefault();
        openNotification();
    });

    $('.notification-close').bind('click touchstart', function(e){
        e.preventDefault();
        closeNotification();
    });

    $('.setting-button').bind('click touchstart', function(e){
        e.preventDefault();
        openSetting();
    });

    $('.setting-close').bind('click touchstart', function(e){
        e.preventDefault();
        closeSetting();
    });

    $.get("<?php echo URL::to('notification/count');?>", function(data){
        $(".all-notify-count").text(data.all);
    }, "json");
});
</script>
</body>
</html>