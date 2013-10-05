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
            <th>ชื่อคลาสเรียน</th>
            <th>กลุ่ม</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        @foreach($classes as $class)
        <tr>
            <td>{{ $class->id }}</td>
            <td>{{ $class->name }}</td>
            <td><a href="{{ URL::to('class/'.$class->id.'/group') }}">{{ $class->group_length }} กลุ่ม</a></td>
            <td class="text-center"><a href="{{ URL::to('class/edit/'.$class->id) }}"><i class="glyphicon glyphicon-edit"></i></a></td>
            <td class="text-center"><a href="{{ URL::to('class/delete?id='.$class->id) }}" class="del-button"><i class="glyphicon glyphicon-remove"></i></a></td>
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

    $('.del-button').bind('touchstart click', function(e){
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