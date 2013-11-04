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
            <input type="file" class="form-control" name="picture">
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>description</label>
        <textarea class="form-control" id="input-description" name="description">@if(@$post['description']){{ $post['description'] }}@endif</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    <a class="btn btn-info pull-right" href="javascript:history.back();">Cancel</a>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
<script type="text/javascript">
$(function(){
    var oldMedia = $('.media');
    $('.field-media').delegate('.reupload-media                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', 'click', function(e){
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