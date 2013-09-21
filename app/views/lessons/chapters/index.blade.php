<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 21/9/2556
 * Time: 7:24 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<div style="background: white;">
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>description</th>
            <th>video</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($chapters as $chapter)
        <tr>
            <td>{{ $chapter->id }}</td>
            <td>{{ $chapter->name }}</td>
            <td>{{ $chapter->description }}</td>
            <td><a href="{{ URL::to('lesson/'.$chapter->lesson_id.'/chapter/'.$chapter->id.'/video') }}">{{ $chapter->video_length }} videos</a></td>
            <td><a class="glyphicon glyphicon-remove edit-button" href="{{ URL::to('lesson/'.$lesson->id.'/chapter/edit/'.$chapter->id) }}"></a></td>
            <td><a class="glyphicon glyphicon-remove del-button" href="{{ URL::to('lesson/'.$lesson->id.'/chapter/delete/'.$chapter->id) }}"></a></td>
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