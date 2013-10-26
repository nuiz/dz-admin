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
    <table class="table table-bordered table-dz">
        <tr>
            <th>name</th>
            <th>picture</th>
            <th>description</th>
            <th>video</th>
            <th>sort down</th>
            <th>sort up</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($chapters as $chapter)
        <tr class="item-sort" item-id="{{ $chapter->id }}">
            <td>{{ $chapter->name }}</td>
            <td>
                @if(@$chapter->picture->id)
                <a href="{{ $chapter->picture->link }}" class="html5lightbox" title="{{ $chapter->name }}">
                    <img src="{{ $chapter->picture->link }}" class="dz-thumb" />
                </a>
                @endif
            </td>
            <td>{{ $chapter->description }}</td>
            <td><a href="{{ URL::to('lesson/'.$chapter->lesson_id.'/chapter/'.$chapter->id.'/video') }}">{{ $chapter->video_length }} videos</a></td>
            <td class="text-center"><a href="" class="glyphicon glyphicon-chevron-down sort-down"></a></td>
            <td class="text-center"><a href="" class="glyphicon glyphicon-chevron-up sort-up"></a></td>
            <td><a class="glyphicon glyphicon-edit edit-button" href="{{ URL::to('lesson/'.$lesson->id.'/chapter/edit/'.$chapter->id) }}"></a></td>
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

        $('.sort-down').bind('click touchstart', function(e){
            e.preventDefault();
            var tr = $(this).closest("tr");
            var next = tr.next(".item-sort");
            if(next.size() > 0){
                next.after(tr);
                var sortData = [];
                $('.item-sort').each(function(index, item){
                    sortData.push($(item).attr("item-id"));
                });
                $.post('{{ URL::to("lesson/".$lesson->id."/chapter/sort") }}', { "sortData": sortData }, function(data){
                    if(typeof data.error != 'undefined'){
                        alert(data.error.message);
                    }
                }, 'json');
            }
        });

        $('.sort-up').bind('click touchstart', function(e){
            e.preventDefault();
            var tr = $(this).closest("tr");
            var prev = tr.prev(".item-sort");
            if(prev.size() > 0){
                prev.before(tr);
                var sortData = [];
                $('.item-sort').each(function(index, item){
                    sortData.push($(item).attr("item-id"));
                });
                $.post('{{ URL::to("lesson/".$lesson->id."/chapter/sort") }}', { "sortData": sortData }, function(data){
                    if(typeof data.error != 'undefined'){
                        alert(data.error.message);
                    }
                }, 'json');
            }
        });
    });
</script>
@stop