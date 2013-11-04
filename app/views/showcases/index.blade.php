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
    <form method="post" class="form-inline add-showcase-form text-center add-showcase-form" role="form" style="padding: 10px; display: none;">
        <div class="form-group">
            <label>youube id</label>
            <input type="text" name="youtube_id">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="to_feed" value="true"> post to feed
            </label>
        </div>
        <button type="submit" class="btn btn-primary submit-showcase">add</button>
    </form>
    <table class="table table-bordered table-dz">
        <tr>
            <th>video name</th>
            <th>video</th>
            <th>youtube link</th>
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
            <td class="text-center"><a href="" class="glyphicon glyphicon-chevron-down sort-down"></a></td>
            <td class="text-center"><a href="" class="glyphicon glyphicon-chevron-up sort-up"></a></td>
            <td class="text-center"><a href="{{ URL::to('showcase/delete/'.$showcase->id); }}" class="glyphicon glyphicon-remove remove-button"></a></td>
        </tr>
        @endforeach
    </table>
</div>
<script type="text/javascript">
/*
 * Shared and maintained by [Nezasa](http://www.nezasa.com)
 * Published under [Apache 2.0 license](http://www.apache.org/licenses/LICENSE-2.0.html)
 * © Nezasa, 2012-2013
 *
 * ---
 *
 * Javascript library for parsing of ISO 8601 durations. Supported are durations of
 * the form P3Y6M4DT12H30M17S or PT1S or P1Y4DT1H3S etc.
 *
 * @author Nezasa AG -- https://github.com/nezasa
 * @contributor Jason "Palamedes" Ellis -- https://github.com/palamedes
 */

(function( nezasa, undefined ) {

    // create sub packages
    if (!nezasa.iso8601) nezasa.iso8601 = {};
    if (!nezasa.iso8601.Period) nezasa.iso8601.Period = {};

    //---- public properties

    /**
     * version of the ISO8601 version
     */
    nezasa.iso8601.version = '0.2';

    //---- public methods

    /**
     * Returns an array of the duration per unit. The normalized sum of all array elements
     * represents the total duration.
     *
     * - array[0]: years
     * - array[1]: months
     * - array[2]: weeks
     * - array[3]: days
     * - array[4]: hours
     * - array[5]: minutes
     * - array[6]: seconds
     *
     * @param period iso8601 period string
     * @param distributeOverflow if 'true', the unit overflows are merge into the next higher units. Defaults to 'false'.
     */
    nezasa.iso8601.Period.parse = function(period, distributeOverflow) {
        return parsePeriodString(period, distributeOverflow);
    };

    /**
     * Returns the total duration of the period in seconds.
     */
    nezasa.iso8601.Period.parseToTotalSeconds = function(period) {

        var multiplicators = [31104000 /* year   (360*24*60*60) */,
            2592000  /* month  (30*24*60*60) */,
            604800   /* week   (24*60*60*7) */,
            86400    /* day    (24*60*60) */,
            3600     /* hour   (60*60) */,
            60       /* minute (60) */,
            1        /* second (1) */];
        var durationPerUnit = parsePeriodString(period);
        var durationInSeconds = 0;

        for (var i = 0; i < durationPerUnit.length; i++) {
            durationInSeconds += durationPerUnit[i] * multiplicators[i];
        }

        return durationInSeconds;
    };

    /**
     * Return boolean based on validity of period
     * @param period
     * @return {Boolean}
     */
    nezasa.iso8601.Period.isValid = function(period) {
        try {
            parsePeriodString(period);
            return true;
        } catch(e) {
            return false;
        }
    }

    /**
     * Returns a more readable string representation of the ISO8601 period.
     * @param period the ISO8601 period string
     * @param unitName the names of the time units if there is only one (such as hour or minute).
     *        Defaults to ['year', 'month', 'week', 'day', 'hour', 'minute', 'second'].
     * @param unitNamePlural thenames of the time units if there are several (such as hours or minutes).
     *        Defaults to ['years', 'months', 'weeks', 'days', 'hours', 'minutes', 'seconds'].
     * @param distributeOverflow if 'true', the unit overflows are merge into the next higher units. Defaults to 'false'.
     */
    nezasa.iso8601.Period.parseToString = function(period, unitNames, unitNamesPlural, distributeOverflow) {

        var result = ['', '', '', '', '', '', ''];
        var durationPerUnit = parsePeriodString(period, distributeOverflow);

        // input validation (use english as default)
        if (!unitNames)       unitNames       = ['year', 'month', 'week', 'day', 'hour', 'minute', 'second'];
        if (!unitNamesPlural) unitNamesPlural = ['years', 'months', 'weeks', 'days', 'hours', 'minutes', 'seconds'];

        // assemble string per unit
        for (var i = 0; i < durationPerUnit.length; i++) {
            if (durationPerUnit[i] > 0) {
                if   (durationPerUnit[i] == 1) result[i] = durationPerUnit[i] + " " + unitNames[i];
                else                           result[i] = durationPerUnit[i] + " " + unitNamesPlural[i];
            }
        }

        // trim because of space at very end and because of join(" ")
        // replace double spaces because of join(" ") and empty strings
        // Its actually possible to get more than 2 spaces in a row,
        //   so lets get 2+ spaces and remove them
        return result.join(' ').trim().replace(/[ ]{2,}/g,' ');
    };

    //---- private methods

    /**
     * Parses a ISO8601 period string.
     * @param period iso8601 period string
     * @param _distributeOverflow if 'true', the unit overflows are merge into the next higher units.
     */
    function parsePeriodString(period, _distributeOverflow) {

        // regex splits as follows
        // grp0 omitted as it is equal to the sample
        //
        // | sample            | grp1   | grp2 | grp3 | grp4 | grp5 | grp6       | grp7 | grp8 | grp9 |
        // --------------------------------------------------------------------------------------------
        // | P1Y2M3W           | 1Y2M3W | 1Y   | 2M   | 3W   | 4D   | T12H30M17S | 12H  | 30M  | 17S  |
        // | P3Y6M4DT12H30M17S | 3Y6M4D | 3Y   | 6M   |      | 4D   | T12H30M17S | 12H  | 30M  | 17S  |
        // | P1M               | 1M     |      | 1M   |      |      |            |      |      |      |
        // | PT1M              | 3Y6M4D |      |      |      |      | T1M        |      | 1M   |      |
        // --------------------------------------------------------------------------------------------

        var distributeOverflow = (_distributeOverflow) ? _distributeOverflow : false;
        var valueIndexes       = [2, 3, 4, 5, 7, 8, 9];
        var duration           = [0, 0, 0, 0, 0, 0, 0];
        var overflowLimits     = [0, 12, 4, 7, 24, 60, 60];
        var struct;

        // upcase the string just in case people don't follow the letter of the law
        period = period.toUpperCase();

        // input validation
        if (!period)                         return duration;
        else if (typeof period !== "string") throw new Error("Invalid iso8601 period string '" + period + "'");

        // parse the string
        if (struct = /^P((\d+Y)?(\d+M)?(\d+W)?(\d+D)?)?(T(\d+H)?(\d+M)?(\d+S)?)?$/.exec(period)) {

            // remove letters, replace by 0 if not defined
            for (var i = 0; i < valueIndexes.length; i++) {
                var structIndex = valueIndexes[i];
                duration[i] = struct[structIndex] ? +struct[structIndex].replace(/[A-Za-z]+/g, '') : 0;
            }
        }
        else {
            throw new Error("String '" + period + "' is not a valid ISO8601 period.");
        }

        if (distributeOverflow) {
            // note: stop at 1 to ignore overflow of years
            for (var i = duration.length - 1; i > 0; i--) {
                if (duration[i] >= overflowLimits[i]) {
                    duration[i-1] = duration[i-1] + Math.floor(duration[i]/overflowLimits[i]);
                    duration[i] = duration[i] % overflowLimits[i];
                }
            }
        }

        return duration;
    };


}( window.nezasa = window.nezasa || {} ));
</script>
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

    function youtube_parser(url){
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match&&match[7].length==11){
            return match[7];
        }else{
            alert("Url incorrecta");
        }
    }

    var submitting = false;
    $('.submit-showcase').bind('click touchstart', function(e){
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
    });
});
</script>
@stop