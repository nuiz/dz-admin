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
            <th>name</th>
            <th>picture or video</th>
            <th>message</th>
            <th>comment</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($news as $new)
        <tr>
            <td>{{ $new->name }}</td>
            <td>
                @if(@$new->picture->id)
                <a href="{{ $new->picture->link }}" class="html5lightbox" title="{{ $new->name }}">
                    <img src="{{ $new->picture->link }}" class="dz-thumb" />
                </a>
                @elseif(@$new->video->id)
                <a href="{{ $new->video->link }}" class="html5lightbox video-thumb" data-width="480" data-height="320" title="{{ $new->name }}">
                    <span class="glyphicon glyphicon-facetime-video video-icon"></span>
                    <img src="{{ $new->video->thumb }}" class="dz-thumb" />
                </a>
                @endif
            </td>
            <td>{{ nl2br($new->message) }}</td>
            <td><a href="<?php echo URL::to("news/{$new->id}/comment");?>">{{ $new->comment->length }}</a></td>
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