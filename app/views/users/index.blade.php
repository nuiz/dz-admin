@section('content')
<div  style="background: white;">
    <table class="table table-bordered table-dz">
        <tr>
            <th></th>
            <th></th>
            <th>username</th>
            <th>name</th>
            <th>email</th>
            <th>group</th>
            <th>type</th>
            <th>upgrade</th>
            <th>remove</th>
        </tr>
        <?php $i=0;?>
        @foreach($users as $user)
        <tr>
            <?php $i++;?>
            <td>{{ $i }}</td>
            <td><img src="http://61.19.147.72/api/user/{{ $user->id }}/picture" width="32" height="32"></td>
            <td><a href="<?php echo URL::to("user/detail/{$user->id}");?>">{{ $user->username }}</a></td>
            <td><a href="<?php echo URL::to("user/detail/{$user->id}");?>">{{ $user->first_name }} {{ $user->last_name }}</a></td>
            <td>{{ $user->email }}</td>
            <td>
                <?php foreach($user->groups->data as $group){ ?>
                    <?php echo $group->class->name." - ".$group->name."<br>"; ?>
                <?php } ?>
            </td>
            <td field_name="type">
                {{ $user->type }}
                <?php if($user->type == "member"){
                    $dateTimeout = new DateTime($user->member_timeout);
                    echo "(หมดอายุ ".$dateTimeout->format("d-m-Y").")";
                }?>
            </td>
            <td class="text-center" style="width: 80px;" field_name="upgrade">
                @if($user->type == 'normal')
                <a class="glyphicon glyphicon-circle-arrow-up upgrade-button" href="{{ URL::to('user/upgrade/'.$user->id) }}"></a>
                @endif
            </td>
            <td class="text-center"><a href="{{ URL::to('user/delete/'.$user->id) }}" class="glyphicon glyphicon-remove remove-button"></a></td>
        </tr>
        @endforeach
    </table>
</div>
<script type="text/template" class="template-duration">
    <div style="line-height: 96px;">
        <select name="year">
            <?php for($i=0; $i<=10; $i++){ ?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php } ?>
        </select> ปี
        <select name="month">
            <?php for($i=0; $i<=11; $i++){ ?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php } ?>
        </select> เดือน
        <select name="day">
            <?php for($i=0; $i<=25; $i++){ ?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php } ?>
        </select> วัน
        <input type="button" class="btn btn-primary upgrade-submit" value="upgrade">
    </div>
</script>
<style type="text/css">
.setting-main-menu {
    position: absolute; height: 44px; width: 44px; top: 0; right: 0;
}
.setting-main-menu.active {
    border: solid white;
    border-width: 1px 1px 0 1px;
}

.setting-menu {
    top: 43px;
    right: 0;
    padding: 4px 6px;
    background: #FFAB33;
    position: absolute;
    width: 135px;
    font-size: 14px;
    z-index: 10;
    border-width: 0 1px 1px 1px;
    border-style: solid;
    border-color: rgb(230, 199, 199);
    display: none;

    line-height: 36px;
}
.setting-menu .setting-list {
    display: block;
}
.setting-menu .setting-list:hover {
    text-decoration: none;
    background: #EEEEEE;
    color: black;
}
.setting-menu .setting-list:not(:first-child) {
    border-top: 1px solid white;
}
.setting-main-menu.active .setting-menu {
    display: block;
    border: solid white;
    border-width: 1px 1px 1px 1px;
}


/**************** change password block **************/
.change-password-bg {
    background: rgba(0,0,0,0.4);
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0; left: 0;
}

.change-password-block {
    background: white;
    width: 400px;
    height: auto;
    position: absolute;
    top: 50%; left: 50%;
    margin-top: -200px;
    margin-left: -200px;
    padding: 20px;
    box-sizing: border-box;
    border-radius: 4px;
}
</style>
<script type="text/template" class="template-setting">
    <div class="setting-main-menu">
        <a href="<?php echo URL::to("logout");?>" class="glyphicon glyphicon-cog setting-button"></a>
        <div class="setting-menu">
            <a href="" class="setting-list change-password-button">Change Password</a>
            <a href="<?php echo URL::to("logout");?>" class="setting-list">Logout</a>
        </div>
    </div>
</script>
<script type="text/template" class="change-password-template">
    <div class="change-password-bg">
        <div class="change-password-block">
            <form class="form-horizontal" role="form">
                <fieldset>
                    <legend class="text-center">Change Password</legend>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Old password</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="password" name="old_password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">New password</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="password" name="new_password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Repeat password</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="password" name="repeat_password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"></label>
                        <div class="col-sm-7">
                            <button class="btn btn-primary chage-password-done pull-left">Done</button>
                            <button class="btn btn-primary chage-password-cancel pull-right">Cancel</button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </fieldset>
            </form>
        </div>
    </div>
</script>
<script type="text/javascript">
$(function(){
    function disabledTr(tr){
        $(tr).css({ opacity: 0.4 });
        $(tr).data('disabled', true);
    }

    function enabledTr(tr)
    {
        $(tr).css({ opacity: 1 });
        $(tr).data('disabled', false);
    }

    $('.upgrade-button').bind('touchstart click', function(e){
        e.preventDefault();

        var tr = $(this).closest('tr');
        if(tr.data('disabled')==true)
            return;
        var href = $(this).attr('href');

        var template = $(".template-duration").html();
        var obj = $(template);
        $.fancybox(obj, { maxHeight: 34 });

        $(".upgrade-submit", obj).click(function(e){
            var year = $('select[name="year"]').val();
            var month = $('select[name="month"]').val();
            var day = $('select[name="day"]').val();

            if(year==0 && month ==0 &&day ==0){
                alert("กรุณาเลือกเวลาในการ upgrade member");
                return false;
            }

            disabledTr(tr);
            $.fancybox.close(true);
            dzApi.call({
                method: 'post',
                url: href,
                data: { type: 'member', year: year, month: month, day: day },
                success: function(data){
                    if(typeof data.error != 'undefined'){
                        enabledTr(tr);
                        alert(data.error.message);
                        return;
                    }

                    enabledTr(tr);
                    var t = new Date(data.member_timeout);
                    var YYYY = t.getFullYear();
                    var MM = ((t.getMonth() + 1 < 10) ? '0' : '') + (t.getMonth() + 1);
                    var DD = ((t.getDate() < 10) ? '0' : '') + t.getDate();
                    var HH = ((t.getHours() < 10) ? '0' : '') + t.getHours();
                    var mm = ((t.getMinutes() < 10) ? '0' : '') + t.getMinutes();
                    var ss = ((t.getSeconds() < 10) ? '0' : '') + t.getSeconds();

                    tr.find('td[field_name="type"]').text(data.type + " (หมดอายุ " + DD + "-" + MM + "-" + YYYY + ")");
                    tr.find('td[field_name="upgrade"]').text("");
                }
            });
        });
    });

    $('.remove-button').bind('touchstart click', function(e){
        e.preventDefault();

        var tr = $(this).closest('tr');
        if(tr.data('disabled')==true)
            return;

        if(!window.confirm('Are you sure?')){
            return;
        }
        disabledTr(tr);

        var href = $(this).attr('href');
        dzApi.call({
            method: 'get',
            url: href,
            success: function(data){
                if(typeof data.error != 'undefined'){
                    enabledTr(tr);
                    alert(data.error.message);
                    return;
                }

                tr.fadeOut(function(){
                    tr.remove();
                });
            }
        });
    });

    $('body').nodoubletapzoom();

    var settingBlock = $($('.template-setting').html());
    $('.container .header').append(settingBlock);

    $('.setting-button', settingBlock).click(function(e){
        e.preventDefault();
        $(settingBlock).toggleClass('active');
    });

    var changePasswordBlock = $($('.change-password-template').html());
    changePasswordBlock.click(function(e){
        e.preventDefault();
        if(this == e.target){
            changePasswordBlock.hide();
        }
    });
    var disabled = false;
    function disabledChange(){
        $('input, button', changePasswordBlock).prop('disabled', true);
        disabled = true;
    }
    function enabledChange(){
        $('input, button', changePasswordBlock).prop('disabled', false);
        disabled = false;
    }
    $('.chage-password-done', changePasswordBlock).click(function(e){
        e.preventDefault();
        if(disabled){
            return;
        }
        var srl = $('form', changePasswordBlock).serializeArray();
        var send = {};
        for(var i in srl){
            send[srl[i].name] = srl[i].value;
        }
        if(send.new_password!=send.repeat_password){
            alert('new password and repeat password not match');
            return;
        }
        disabledChange();
        $.post("<?php echo URL::to("change_password");?>", send, function(data){
            if(typeof data.error != "undefined"){
                alert(data.error.message);
            }
            else {
                alert("Change password success");
                changePasswordBlock.hide();
            }
            enabledChange();
        }, "json");
    });
    $('.chage-password-cancel', changePasswordBlock).click(function(e){
        e.preventDefault();
        changePasswordBlock.hide();
    });
    $('.change-password-button').click(function(e){
        e.preventDefault();
        changePasswordBlock.appendTo('body');
        changePasswordBlock.show();
        $('input', changePasswordBlock).val('');
        $(settingBlock).removeClass('active');
    });
});
</script>
@stop