<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 19/9/2556
 * Time: 16:15 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<style type="text/css">
.create-form {
    width: 400px;
    margin: 20px auto;
    background: white;
    border-radius: 4px;
    padding: 20px;
}
</style>
<form class="create-form" method="post" enctype="multipart/form-data">
    <legend>{{ $header }}</legend>
    <div class="form-group">
        <label>news name</label>
        <input type="text" class="form-control" name="name" value="@if(@$post['name']){{ $post['name'] }}@endif">
    </div>
    <div class="form-group field-media">
        <label>ไฟล์แนบ(รูปภาพหรือวีดีโอ)</label>
        <div class="media-block">
        @if(@$post['media_type']=='video')
            <div class="field-video media">
                <div class="menu"><a href="#" class="delete-media">เอาออก</a> <a href="#" class="reupload-media">upload ใหม่</a></div>
                <video width="320" height="240">
                    <source src="{{ $post['video']['link'] }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @elseif(@$post['media_type']=='picture')
            <div class="field-img media">
                <div class="menu"><a href="#" class="delete-media">เอาออก</a> <a href="#" class="reupload-media">upload ใหม่</a></div>
                <img src="{{ $post['picture']['link'] }}" />
            </div>
        @else
            <input type="file" class="form-control" name="media">
        @endif
        </div>
    </div>
    <div class="form-group">
        <label>message</label>
        <textarea class="form-control" name="message">@if(@$post['message']){{ $post['message'] }}@endif</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
<script type="text/javascript">
$(function(){
    $('.delete-media').click(function(e){
        e.preventDefault();
        $('.field-media').html('<input type="hidden" name="deleteMedia" value="yes">');
    });
    $('.reupload-media').click(function(e){
        e.preventDefault();
        $('.media-block').html('<input type="file" class="form-control" name="media">');
    });
});
</script>
@stop