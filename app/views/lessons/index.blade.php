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
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>logo</th>
            <th>color</th>
            <th>name</th>
            <th>chapter</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($lessons as $lesson)
        <tr>
            <td>{{ $lesson->id }}</td>
            <td><img src="{{ $lesson->logo_link }}" height="32"></td>
            <td class="lesson-color">{{ $lesson->color }}</td>
            <td>{{ $lesson->name }}</td>
            <td><a href="{{ URL::to('lesson/'.$lesson->id.'/chapter') }}">{{ $lesson->chapter_length }} capters</a></td>
            <td><a href="{{ URL::to('lesson/edit/'.$lesson->id) }}" class="glyphicon glyphicon-edit edit-button"></a></td>
            <td><a href="{{ URL::to('lesson/delete/'.$lesson->id) }}" class="glyphicon glyphicon-remove del-button"></a></td>
        </tr>
        @endforeach
    </table>
</div>
<script type="text/javascript">
$(function(){
    function makeColor()
    {
        $('.lesson-color').each(function(index, el){
            $(this).css({ background: $(this).text() });
        });
    }
    makeColor();

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