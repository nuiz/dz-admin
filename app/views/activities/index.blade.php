<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 21/9/2556
 * Time: 6:50 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<div style="background: white;">
    <table class="table table-bordered table-dz">
        <tr>
            <th>date</th>
            <th>name</th>
            <th>picture</th>
            <th>message</th>
            <th>user joined</th>
            <th>comment</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($activities as $activity)
        <tr>
            <td>{{ $activity->start_time }}</td>
            <td>{{ $activity->name }}</td>
            <td>
                @if(@$activity->picture->id)
                <a href="{{ $activity->picture->link }}" class="html5lightbox" title="{{ $activity->name }}">
                    <img src="{{ $activity->picture->link }}" class="dz-thumb" />
                </a>
                @endif
            </td>
            <td>{{ $activity->message }}</td>
            <td>
                {{ $activity->user_length }}
            </td>
            <td><a href="<?php echo URL::to("activity/{$activity->id}/comment");?>">{{ $activity->comment->length }}</a></td>
            <td><a href="{{ URL::to('activity/edit/'.$activity->id) }}" class="glyphicon glyphicon-edit edit-button"></a></td>
            <td><a href="{{ URL::to('activity/delete/'.$activity->id) }}" class="glyphicon glyphicon-remove del-button"></a></td>
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