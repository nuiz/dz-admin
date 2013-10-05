<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 21/9/2556
 * Time: 7:23 น.
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
        <label>name</label>
        <input type="text" class="form-control" name="name" value="@if(@$post['name']){{ $post['name'] }}@endif">
    </div>
    <div class="form-group field-media">
        <label>cover pic</label>
        <div class="media-block">
            @if(@$post['picture']['id'])
            <div class="field-img media">
                <div class="menu"><a href="#" class="delete-media">เอาออก</a> <a href="#" class="reupload-media">upload ใหม่</a></div>
                <img src="{{ $post['picture']['link'] }}" />
            </div>
            @else
            <input type="file" class="form-control" name="picture">
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>start_time</label>
        <input type="datetime-local" class="form-control" name="start_time" value="@if(@$post['start_time']){{ date("Y-m-d\TH:i", strtotime($post['start_time'])) }}@endif">
    </div>
    <div class="form-group">
        <label>message</label>
        <textarea type="text" class="form-control" name="message">@if(@$post['message']){{ $post['message'] }}@endif</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
<script type="text/javascript">
    $(function(){
        $('.reupload-media').click(function(e){
            e.preventDefault();
            $('.media-block').html('<input type="file" class="form-control" name="picture">');
        });
        $('.delete-media').click(function(e){
            e.preventDefault();
            $('.field-media').html('<input type="hidden" name="deletePicture" value="yes">');
        });
    });
</script>
@stop