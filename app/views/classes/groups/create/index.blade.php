<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 18/9/2556
 * Time: 13:05 น.
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
        <input type="text" class="form-control" id="input-name" name="name" value="@if(@$post['name']){{ $post['name'] }}@endif">
    </div>
    <div class="form-group field-media">
        <label>video file</label>
        <div class="media-block">
            @if(@$post['video']['link'])
            <div class="field-video media">
                <div class="menu"><a href="#" class="reupload-media">upload ใหม่</a></div>
                <video width="320" height="240">
                    <source src="{{ $post['video']['link'] }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            @else
            <div class="media">
                <input type="file" class="form-control" name="video">
            </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>description</label>
        <textarea class="form-control" id="input-description" name="description">@if(@$post['description']){{ $post['description'] }}@endif</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    <button class="btn btn-info pull-right cancle-button">Reset</button>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
<script type="text/javascript">
    $(function(){
        var oldMedia = $('.media');
        $('.field-media').delegate('.reupload-media', 'click', function(e){
            e.preventDefault();
            $('.media-block').html('<input type="file" class="form-control" name="video">');
        });

        var oldData = <?php echo isset($oldData)? json_encode($oldData): 'null'; ?>;
        var inputName = $('#input-name');
        var inputDes = $('#input-description');
        $('.cancle-button').click(function(e){
            e.preventDefault();
            if(oldData==null){
                inputName.val("");
                inputDes.val("");
                $('input[name="picture"]').val('');
            }
            else {
                inputName.val(oldData.name);
                inputDes.val(oldData.description);
                $('.media-block').html('').append(oldMedia);
                $('.field-media').show();
            }
        });

    });
</script>
@stop