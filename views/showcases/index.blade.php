<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 20/9/2556
 * Time: 12:39 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<div style="background: white;">
    <form method="post" class="add-showcase-form text-center add-showcase-form" style="padding: 10px; display: none;">
        <label>youube id</label>
        <input type="text" name="youtube_id">
        <button type="submit" class="btn btn-primary">add</button>
    </form>
    <table class="table table-bordered table-dz">
        <tr>
            <th>id</th>
            <th>video name</th>
            <th>youtube link</th>
            <th>delete</th>
        </tr>
        @foreach($showcases as $showcase)
        <tr>
            <td>{{ $showcase->id }}</td>
            <td>{{ $showcase->name }}</td>
            <td><a href="http://www.youtube.com/watch?v={{ $showcase->youtube_id }}" target="_blank">http://www.youtube.com/watch?v={{ $showcase->youtube_id }}</a></td>
            <td class="text-center"><a class="glyphicon glyphicon-remove remove-button" href="{{ URL::to('showcase/delete/'.$showcase->id) }}"></a></td>
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

    $('.add-button').bind('touchstart click', function(e){
        e.preventDefault();
        $('.add-showcase-form').slideToggle();
    });

    /*
    $('.youtube_id').each(function(index, el){
        var youtube_id = $(el).text();
        var href = 'http://gdata.youtube.com/feeds/api/videos?q='+youtube_id+'&v=2&alt=jsonc';
        console.log(href);
        $.get(href, function(data){
            console.log(data);
            $(el).text(data.data.items[0].title);
        }, 'json');
    });
    */

    $('.remove-button').bind('touchstart click', function(e){
        e.preventDefault();
        var tr = $(this).closest('tr');
        if(tr.data('disabled')){
            return;
        }
        if(!window.confirm('Are you shure?')){
            return;
        }
        disabledTr(tr);
        var href = $(this).attr('href');

        $.get(href, function(data){
            if(typeof data.error != 'undefined'){
                enabledTr(tr);
                alert(data.error);
            }

            tr.fadeOut(function(){
                tr.remove();
            })
        }, 'json');
    });
});
</script>
@stop