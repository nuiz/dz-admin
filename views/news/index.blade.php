<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 19/9/2556
 * Time: 13:49 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<div style="background: white;">
    <table class="table table-bordered table-dz">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>picture or video</th>
            <th>message</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($news as $new)
        <tr>
            <td>{{ $new->id }}</td>
            <td>{{ $new->name }}</td>
            <td>
                @if(@$new->picture->id)
                <a href="{{ $new->picture->link }}" class="glyphicon glyphicon-picture"></a>
                @elseif(@$new->video->id)
                <a href="{{ $new->video->link }}" class="glyphicon glyphicon-facetime-video"></a>
                @endif
            </td>
            <td>{{ nl2br($new->message) }}</td>
            <td><a class="glyphicon glyphicon-edit" href="{{ URL::to('news/edit/'.$new->id) }}"></a></td>
            <td><a class="glyphicon glyphicon-remove action-remove" href="{{ URL::to('news/delete/'.$new->id) }}"></a></td>
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

    $('.action-remove').bind('touchstart click', function(e){
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
});
</script>
@stop