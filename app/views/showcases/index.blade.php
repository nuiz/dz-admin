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
    <form method="get" action="<?php echo URL::to("showcase/create");?>" class="form-inline add-showcase-form text-center add-showcase-form" role="form" style="padding: 10px; display: none;">
        <div class="form-group">
            <label>youtube link</label>
            <input type="text" name="youtube_link">
        </div>
        <button type="submit" class="btn btn-primary submit-showcase">add</button>
    </form>
    <table class="table table-bordered table-dz">
        <tr>
            <th>video name</th>
            <th>video</th>
            <th>youtube link</th>
            <th>comment</th>
            <th>sort down</th>
            <th>sort up</th>
            <th>delete</th>
        </tr>
        @foreach($showcases as $showcase)
        <tr class="item-sort" item-id="{{ $showcase->id }}">
            <td>{{ $showcase->name }}</td>
            <td>
                <a href="http://youtube.com/v/{{ $showcase->youtube_id }}" class="html5lightbox video-thumb" data-width="480" data-height="320" title="{{ $showcase->name }}">
                    <span class="glyphicon glyphicon-facetime-video video-icon"></span>
                    <img src="{{ $showcase->thumb }}" class="dz-thumb" />
                </a>
            </td>
            <td><a href="http://www.youtube.com/watch?v={{ $showcase->youtube_id }}" target="_blank">http://www.youtube.com/watch?v={{ $showcase->youtube_id }}</a></td>
            <td><a href="<?php echo URL::to("showcase/{$showcase->id}/comment");?>">{{ $showcase->comment->length }}</a></td>
            <td class="text-center"><a href="" class="glyphicon glyphicon-chevron-down sort-down"></a></td>
            <td class="text-center"><a href="" class="glyphicon glyphicon-chevron-up sort-up"></a></td>
            <td class="text-center"><a href="{{ URL::to('showcase/delete/'.$showcase->id); }}" class="glyphicon glyphicon-remove remove-button"></a></td>
        </tr>
        @endforeach
    </table>
</div>
<script type="text/javascript">
function clickAdd(e)
{
    //e.preventDefault();
    $('.add-showcase-form').slideToggle();
    return false;
}

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

    /*
    $('.add-button').bind('touchstart click', function(e){
        e.preventDefault();
        $('.add-showcase-form').slideToggle();
    });
    */

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
            $.post('{{ URL::to("showcase/sort") }}', { "sortData": sortData }, function(data){
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
            $.post('{{ URL::to("showcase/sort") }}', { "sortData": sortData }, function(data){
                if(typeof data.error != 'undefined'){
                    alert(data.error.message);
                }
            }, 'json');
        }
    });

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

    var submitting = false;
    $('.submit-showcase').bind('click touchstart', function(e){
        /*
        e.preventDefault();
        if(submitting)
            return;

        submitting = true;
        var form = $(this).closest('form');
        $('input[name="youtube_id"]', form).attr('disabled', true);

        var youtube_id = $('input[name="youtube_id"]', form).val();
        youtube_id = youtube_parser(youtube_id);
        $.get("https://www.googleapis.com/youtube/v3/videos?id="+youtube_id+"&key=AIzaSyA1reRMMGfDbsiJzqUvXWaNgQrmGdaCAk8&part=snippet,contentDetails,statistics", function(data){
            if(data.items.length == 0){
                submitting = false;
                $('input[name="youtube_id"]', form).attr('disabled', false);
                alert('not found video');
            }
            var video = data.items[0];

            var duration = nezasa.iso8601.Period.parseToTotalSeconds(video.contentDetails.duration);
            var name = video.snippet.title;
            var description = video.snippet.description;
            var thumb = video.snippet.thumbnails.high.url;
            var like_count = video.statistics.likeCount;
            var view_count = video.statistics.viewCount;
            var comment_count = video.statistics.commentCount;

            var dataSend = {
                "youtube_id": youtube_id,
                "name": name,
                "description": description,
                "thumb": thumb,
                "duration": duration,
                "like_count": like_count,
                "view_count": view_count,
                "comment_count": comment_count
            };
            if($('input[name="to_feed"]', form).is(":checked")){
                dataSend.to_feed = "true";
            }
            $.post("", dataSend, function(data){
                submitting = false;
                if(typeof data.error != 'undefined'){
                    alert(data.error.message);
                    $('input[name="youtube_id"]', form).attr('disabled', false);
                    return;
                }
                window.location.reload();
            }, 'json');
        }, 'json');
        */
    });
});
</script>
@stop