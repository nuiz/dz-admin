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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <!--<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.mobile.min.css') }}>-->
</head>
<body>

<div class="container">
    <div class="header">
        {{ $header }}
    </div>
    <div class="main-body">
        @yield('content')
    </div>
    <div class="main-nav">
        <a class="mainnav-btn" href="<?php echo URL::to('news');?>">news</a>
        <a class="mainnav-btn" href="<?php echo URL::to('showcase');?>">showcase</a>
        <a class="mainnav-btn" href="<?php echo URL::to('lesson');?>">lesson</a>
        <a class="mainnav-btn" href="<?php echo URL::to('activity');?>">activity</a>
        <a class="mainnav-btn" href="<?php echo URL::to('user');?>">user</a>
        <a class="mainnav-btn" href="<?php echo URL::to('class');?>">class & group</a>
    </div>
</div>
<script type="text/javascript">
$(function(){

    function setBodySize(){
        var allH = $(window).height();
        var contentH = allH-88;
        $('.main-body').height(contentH);
    }
    setBodySize();

    window.onorientationchange = setBodySize();
});
</script>
</body>
</html>