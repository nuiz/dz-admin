<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 21/9/2556
 * Time: 8:17 น.
 * To change this template use File | Settings | File Templates.
 */
?>

@section('content')
<div style="background: white;">
    <table class="table table-bordered table-dz">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>type</th>
            <th>video</th>
            <th>description</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($videos as $video)
        <tr>
            <td>{{ $video->id }}</td>
            <td>{{ $video->name }}</td>
            <td>@if($video->is_public==1) public @else private @endif</td>
            <td><a href="{{ $video->link }}" class="glyphicon glyphicon-facetime-video"></a></td>
            <td>{{ nl2br($video->description) }}</td>
            <td><a class="glyphicon glyphicon-edit" href="{{ URL::to('lesson/'.$lesson->id.'/chapter/'.$chapter->id.'/video/edit/'.$video->id) }}"></a></td>
            <td><a class="glyphicon glyphicon-remove action-remove" href="{{ URL::to('lesson/'.$lesson->id.'/chapter/'.$chapter->id.'/video/delete/'.$video->id) }}"></a></td>
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