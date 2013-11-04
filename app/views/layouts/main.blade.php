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
            <a class="mainnav-btn @if(@$menu=='joinus'){{ 'active' }}@endif" href="<?php echo URL::to('joinus');?>">Join us</a>
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
</div>
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
        window.scrollTo(0,0);
        //$('.main-body').height(contentH);
    }
    setBodySize();

    window.onorientationchange = setBodySize;
});

$(function(){
    var nfContext = $('.notification-container');
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

    window.onpopstate = function(event) {
        if(window.location.hash == "#notification"){
            openNotification();
        }
        else {
            closeNotification();
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

    $.get("<?php echo URL::to('notification/count');?>", function(data){
        $(".all-notify-count").text(data.all);
    }, "json");
});
</script>
</body>
</html>