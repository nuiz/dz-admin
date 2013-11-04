<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 1/11/2556
 * Time: 15:25 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<style type="text/css">
.sub-nav {
    float: left;
    display: block;
    text-align: center;
    line-height: 34px;
    width: 120px;
}
.sub-nav.active {
    background: #CCCCCC;
    color: black;
}
.sub-nav:active, .sub-nav:hover {
    background: #CCCCCC;
    color: white;
    text-decoration: none;
}
</style>
<div style="background: #EEEEEE;">
    <div style="width: 360px; margin: 0 auto;">
        <a href="<?php echo URL::to("activity");?>" class="sub-nav <?php if($menu=="activity"){ echo "active"; }?>">Activity</a>
        <a href="<?php echo URL::to("class");?>" class="sub-nav <?php if($menu=="class"){ echo "active"; }?>">Class</a>
        <a href="<?php echo URL::to("calendar");?>" class="sub-nav <?php if($menu=="calendar"){ echo "active"; }?>">Calendar</a>
    </div>
    <div class="clearfix"></div>
</div>
{{ $content }}
@stop