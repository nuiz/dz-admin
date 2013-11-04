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
        <input type="text" id="input-name" class="form-control" name="name" value="@if(@$post['name']){{ $post['name'] }}@endif">
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
            <div class="media">
                <input type="file" class="form-control" name="picture">
            </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>start_time</label>
        <input type="datetime-local" id="input-start_time" class="form-control" name="start_time" value="@if(@$post['start_time']){{ date("Y-m-d\TH:i", strtotime($post['start_time'])) }}@endif">
    </div>
    <div class="form-group">
        <label>message</label>
        <textarea type="text" class="form-control" id="input-message" name="message">@if(@$post['message']){{ $post['message'] }}@endif</textarea>
    </div>
    @if(@$feed_checkbox)
    <div class="checkbox">
        <label><input type="checkbox" name="to_feed" value="true" @if($to_feed) "checked" @endif> feed to update</label>
    </div>
    @endif
    <button class="btn btn-primary" type="submit">Submit</button>
    <a class="btn btn-info pull-right" href="javascript:history.back();">Cancel</a>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
<script type="text/javascript">
    $(function(){
        var oldMedia = $('.media');
        $('.field-media').delegate('.reupload-media', 'click', function(e){
            e.preventDefault();
            $('.media-block').html('<input type="file" class="form-control" name="picture">');
        });
        $('.field-media').delegate('.delete-media', 'click', function(e){
            e.preventDefault();
            $('.media-block').html('<input type="hidden" name="deletePicture" value="yes">');
            $('.field-media').hide();
        });

        var oldData = <?php echo isset($oldData)? json_encode($oldData): 'null'; ?>;
        var inputName = $('#input-name');
        var inputStartTime = $('#input-start_time');
        var inputMessage = $('#input-message');
        $('.cancle-button').click(function(e){
            e.preventDefault();
            if(oldData==null){
                inputName.val("");
                inputStartTime.val("");
                inputMessage.val("");
            }
            else {
                inputName.val(oldData.name);
                inputMessage.val(oldData.message)
                inputStartTime.val('<?php echo isset($oldData)? date("Y-m-d\TH:i", strtotime($oldData->start_time)): ""; ?>');
                $('.media-block').html('').append(oldMedia);
                $('.field-media').show();
            }
        });
    });
</script>
@stop