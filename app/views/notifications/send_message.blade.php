<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 17/10/2556
 * Time: 12:53 น.
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="">
    <form class="create-form form" method="post" enctype="multipart/form-data">
        <legend>Create Message</legend>
        <div class="form-group" style="position: relative;">
            <label>ส่งถึง</label>
            <div id="send-to" style="background-color: #eee;
min-height: 34px;
line-height: 34px;
padding: 0 10px;"></div>
            <a class="glyphicon glyphicon-plus-sign add-contact"
                 style="
                 position: absolute; top: 28px;
                left: auto;
                right: 6px;
                font-size: 22px; cursor: pointer;"></a>
        </div>
        <div class="form-group block-add-contact" style="display: none;">
            <ul class="nav nav-tabs">
                <li class="active"><a href="" class="chose-type" rel="class">Class</a></li>
                <li><a href="" class="chose-type" rel="group">Group</a></li>
                <li><a href="" class="chose-type" rel="activity">Activity</a></li>
                <li><a href="" class="chose-type" rel="user">User</a></li>
            </ul>
            <div style="padding-top: 10px;">
                <div class="type-contact" rel="class" style="display: none; max-height: 200px;">
                    <?php
                    if($classes->length > 0){
                        echo <<<HTML
<a href="" class="check-all-type">check all</a> / <a href="" class="uncheck-all-type">uncheck all</a>
HTML;
                    }
                    foreach($classes->data as $key => $value){
                        echo <<<HTML
                        <div class="checkbox">
        <label>
          <input class="checkbox-contact" type='checkbox' data-type='class' data-object_id='{$value->id}' value='{$value->name}' />{$value->name}
        </label>
      </div>
HTML;
                    }
                    ?>
                </div>
                <div class="type-contact" rel="group" style="display: none; max-height: 200px;">
                    <?php
                    if($groups->length > 0){
                        echo <<<HTML
<a href="" class="check-all-type">check all</a> / <a href="" class="uncheck-all-type">uncheck all</a>
HTML;
                    }
                    foreach($groups->data as $key => $value){
                        echo <<<HTML
                        <div class="checkbox">
                        <label>
          <input class="checkbox-contact" type='checkbox' data-type='group' data-object_id='{$value->id}' value='{$value->name}' />{$value->name}(อยู่ในคลาส {$value->class->name})
        </label>
        </div>
HTML;
                    }
                    ?>
                </div>
                <div class="type-contact" rel="activity" style="display: none; max-height: 200px;">
                    <?php
                    if($activities->length > 0){
                        echo <<<HTML
<a href="" class="check-all-type">check all</a> / <a href="" class="uncheck-all-type">uncheck all</a>
HTML;
                    }
                    foreach($activities->data as $key => $value){
                        echo <<<HTML
                        <div class="checkbox">
                        <label>
          <input class="checkbox-contact" type='checkbox' data-type='activity' data-object_id='{$value->id}' value='{$value->name}' />{$value->name}
        </label>
        </div>
HTML;
                    }
                    ?>
                </div>
                <div class="type-contact" rel="user" style="display: none; max-height: 200px;">
                    <?php
                    if($users->length > 0){
                        echo <<<HTML
<a href="" class="check-all-type">check all</a> / <a href="" class="uncheck-all-type">uncheck all</a>
HTML;
                    }
                    foreach($users->data as $key => $value){
                        $displayName = empty($value->username)? $value->first_name.' '.$value->last_name: $value->username;
                        $bf = trim($displayName);
                        if($bf==""){
                            $displayName = $value->email;
                        }
                        echo <<<HTML
                        <div class="checkbox">
                        <label>
          <input class="checkbox-contact" type='checkbox' data-type='user' data-object_id='{$value->id}' value='{$displayName}' />{$displayName}
        </label>
        </div>
HTML;
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>ข้อความ</label>
            <textarea class="form-control notify-message-send" style="height: 200px;"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit" class="btn btn-primary submit-message">
        </div>
    </form>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
$(function(){
    $('.add-contact').click(function(){
        $('.block-add-contact').slideToggle();
    });
    $('.chose-type').bind('click touchstart', function(e){
        e.preventDefault();
        var rel = $(this).attr("rel");
        $('.type-contact').hide();
        $('.type-contact[rel="'+rel+'"]').show();

        $('.chose-type').closest('li').removeClass('active');
        $(this).closest('li').addClass('active');
    });
    $('.chose-type').first().click();

    var contactObject = {
        "class": {},
        "group": {},
        "activity": {},
        "user": {}
    };

    function chkChange(){
        $('#send-to').val("");
        var str = "";
        contactObject = {
            "class": {},
            "group": {},
            "activity": {},
            "user": {}
        };
        var items = [];
        $('.checkbox-contact:checked').each(function(index, item){
            var chk = $(this);
            var val = $(this).val();
            var object_id = $(this).data("object_id");
            var type = $(this).data("type");

            var item = $('<span class="label label-warning" style="margin: 0 4px; cursor: pointer; display: inline-block;">['+type+']'+val+'</span>');
            items.push(item);
            item.bind('click touchstart', function(e){
                chk.prop("checked", false);
                this.remove();
            });
            //str += '<span class="label label-default">['+type+']'+val+'</span> ';
            //contactObject[type][object_id] = object_id;
        });
        $('#send-to').html("");
        $.each(items, function(index, item){
            $('#send-to').append(item);
        });
    }
    $('.checkbox-contact').change(chkChange);

    $('.check-all-type').bind('click touchstart', function(e){
        e.preventDefault();
        $(this).siblings(".checkbox").find(":checkbox").prop("checked", true);
        chkChange();
    });
    $('.uncheck-all-type').bind('click touchstart', function(e){
        e.preventDefault();
        $(this).siblings(".checkbox").find(":checkbox").prop("checked", false);
        chkChange();
    });

    $('.submit-message').bind('click touchstart', function(e){
        e.preventDefault();

        var messageSend = $('.notify-message-send').val();
        var loadingIcon = $('<img class="loading-container" src="<?php echo URL::to("img/ajax-loader.gif"); ?>">');
        $('.notification-content').html("").append(loadingIcon);
        $.post('notification/send', { message: messageSend, contact: contactObject }, function(data){
            loadingIcon.remove();
            $('.notification-content').html("<div style='margin-top: 20%; text-align: center;'>Send notification success.");
        }, "json");
    });
});
</script>