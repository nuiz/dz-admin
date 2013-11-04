<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 2/11/2556
 * Time: 10:52 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<div style="background: white;">
    <div class="setting-container">
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
<script type="text/javascript">
$(function(){
    var stContext = $('.setting-container');
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

    /*
    * setting button
    *
    var settingButton = $('<a href="" class="glyphicon glyphicon-cog setting-button"></a>');
    $('.container .header').append(settingButton);
    */
    var formSetting = $('.form-setting');

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
    /*
    $.get("<?php echo URL::to("setting"); ?>", function(data){
        formSetting.show();
        loadingSettingIcon.remove();
        setData(data);
        oldData = data;
    }, "json");
    */
    oldData = <?php echo json_encode($setting);?>;
    setData(oldData);

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
});
</script>