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
            <th>ชื่อกลุ่ม</th>
            <th>video</th>
            <th>start</th>
            <th>expire</th>
            <th>user</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($groups as $group)
        <tr>
            <td>{{ $group->name }}</td>
            <td>
                <a href="{{ $group->video->link }}" class="html5lightbox video-thumb" title="{{ $group->name }}">
                    <span class="glyphicon glyphicon-facetime-video video-icon"></span>
                    <img src="{{ $group->video->thumb }}" class="dz-thumb" />
                </a>
            </td>
            <td><?php $dateTime = new DateTime($group->group_week->date_start); echo $dateTime->format("Y F d");?></td>
            <td><?php $dateTime = new DateTime($group->group_week->date_end); echo $dateTime->format("Y F d");?></td>
            <td><a href="{{ URL::to('class/'.$classed->id.'/group/'.$group->id.'/user') }}">{{ $group->user_length }} user</a></td>
            <td class="text-center"><a class="edit-group-button" href="{{ URL::to('class/'.$classed->id.'/group/edit/'.$group->id) }}"><i class="glyphicon glyphicon-edit"></i></a></td>
            <td class="text-center"><a class="delete-group-button" href="{{ URL::to('class/'.$classed->id.'/group/delete?id='.$group->id) }}"><i class="glyphicon glyphicon-remove"></i></a></td>
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