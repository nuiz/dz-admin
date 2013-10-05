<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 18/9/2556
 * Time: 14:15 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<div style="background: white;">
    <div class="text-center" style="padding: 10px;">
        search <input type="text" id="search-input" autocapitalize="off"> <button class="btn btn-warning" id="search-button">search</button>
    </div>
    <table class="table table-bordered table-dz" id="user-can-import">
        <tr>
            <th>id</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>email</th>
            <th>เพิ่มลงไปในกลุ่ม</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td field_name="id">{{ $user->id }}</td>
            <td field_name="first_name">{{ $user->first_name }}</td>
            <td field_name="last_name">{{ $user->last_name }}</td>
            <td field_name="email">{{ $user->email }}</td>
            <td class="text-center"><a href="{{ URL::to('class/'.$classed->id.'/group/'.$group->id.'/user/import/'.$user->id) }}" class="glyphicon glyphicon-save import-button"></a></td>
        </tr>
        @endforeach
    </table>
</div>
<script type="text/javascript">
$(function(){
    $('#search-button').bind('touchstart click', function(e){
        var txtsearch = $('#search-input').val().toLowerCase();
        e.preventDefault();
        $('#user-can-import').find('tr').each(function(key, item){
            var id = $(item).find('td[field_name="id"]').text();
            var first_name = $(item).find('td[field_name="first_name"]').text();
            var last_name = $(item).find('td[field_name="last_name"]').text();
            var email = $(item).find('td[field_name="email"]').text();

            if(id.toLowerCase().indexOf(txtsearch)== -1
                && first_name.toLowerCase().indexOf(txtsearch)== -1
                && last_name.toLowerCase().indexOf(txtsearch)== -1
                && email.toLowerCase().indexOf(txtsearch)== -1){
                $(item).hide();
            }
            else {
                $(item).show();
            }
        });
    });

    function disabledTr(tr){
        $(tr).css({ opacity: 0.4 });
        $(tr).data('disabled', true);
    }

    function enabledTr(tr)
    {
        $(tr).css({ opacity: 1 });
        $(tr).data('disabled', false);
    }

    $('.import-button').bind('touchstart click', function(e){
        e.preventDefault();

        var tr = $(this).closest('tr');
        if(tr.data('disabled')==true)
            return;

        if(!window.confirm('Are you sure?')){
            return;
        }
        disabledTr(tr);

        var href = $(this).attr('href');
        $.post(href, function(data){
            if(typeof data.error != 'undefined'){
                enabledTr(tr);
                alert(data.error.message);
                return;
            }
            console.log(data);
            tr.fadeOut(function(){
                tr.remove();
            });
        }, 'json');
    });
});
</script>
@stop