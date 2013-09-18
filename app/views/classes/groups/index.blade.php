<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 16/9/2556
 * Time: 9:42 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')

<div style="background: white;">
    <table class="table table-bordered table-dz">
        <tr>
            <th>id</th>
            <th>ชื่อกลุ่ม</th>
            <th>จำนวนคนในกลุ่ม</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        @foreach($groups as $group)
        <tr>
            <td>{{ $group->id }}</td>
            <td>{{ $group->name }}</td>
            <td>{{ $group->users->length }}</td>
            <td class="text-center"><a class="edit-group-button" href="{{ URL::to('class/'.$classed->id.'/group/'.$group->id.'/edit') }}"><i class="glyphicon glyphicon-edit"></i></a></td>
            <td class="text-center"><a class="delete-group-button": href="{{ URL::to('class/'.$classed->id.'/group/delete?id='.$group->id) }}"><i class="glyphicon glyphicon-remove"></i></a></td>
        </tr>
        @endforeach
    </table>
</div>
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

    $('.delete-group-button').bind('touchstart click', function(e){
        e.preventDefault();

        var tr = $(this).closest('tr');
        if(tr.data('disabled')==true)
            return;

        if(!window.confirm('Are you sure?')){
            return;
        }
        disabledTr(tr);

        var href = $(this).attr('href');
        $.get(href, function(data){
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