@section('content')
<div  style="background: white;">
    <table class="table table-bordered table-dz">
        <tr>
            <th></th>
            <th>name</th>
            <th>surname</th>
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
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
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
});
</script>

@stop