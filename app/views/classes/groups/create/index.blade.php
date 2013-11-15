<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 18/9/2556
 * Time: 13:05 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<?php
function printHoursSelect($name){
    echo '<select name="'.$name.'" class="selectbox_day">';
    $time = "";
    for($i = 0; $i < 48; $i++){
        $time = sprintf("%02s", (int)($i/2));
        $time .= ($i%2==1)? ":30": ":00";
        echo '<option value="'.$time.':00">'.$time.'</option>';
    }
    echo '</select>';
}
?>
<style type="text/css">
.create-form {
    width: 400px;
    margin: 20px auto;
    background: white;
    border-radius: 4px;
    padding: 20px;
}
.hidden-field {
    display: none;
}
</style>
<form class="create-form" method="post" enctype="multipart/form-data">
    <legend>{{ $header }}</legend>
    <div class="form-group">
        <label>name</label>
        <input type="text" class="form-control" id="input-name" name="name" value="@if(@$post['name']){{ $post['name'] }}@endif">
    </div>
    <div class="form-group field-media">
        <label>video file</label>
        <div class="media-block">
            @if(@$post['video']['link'])
            <div class="field-video media">
                <div class="menu"><a href="#" class="reupload-media">upload ใหม่</a></div>
                <video width="320" height="240">
                    <source src="{{ $post['video']['link'] }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            @else
            <div class="media">
                <input type="file" class="form-control" name="video">
            </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>description</label>
        <textarea class="form-control" id="input-description" name="description">@if(@$post['description']){{ $post['description'] }}@endif</textarea>
    </div>
    <legend>วันเวลาที่สอน</legend>
    <div class="form-group form-inline">
        <label class="col-sm-3 checkbox"><input type="checkbox" name="group_week[sun_active]" class="checkbox_day sun" value="active"> Sun</label>
        <div class="col-sm-8">
            <?php printHoursSelect("group_week[sun_start]");?> ถึง <?php printHoursSelect("group_week[sun_end]");?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group form-inline">
        <label class="col-sm-3 checkbox"><input type="checkbox" name="group_week[mon_active]" class="checkbox_day mon" value="active"> Mon</label>
        <div class="col-sm-8">
            <?php printHoursSelect("group_week[mon_start]");?> ถึง <?php printHoursSelect("group_week[mon_end]");?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group form-inline">
        <label class="col-sm-3 checkbox"><input type="checkbox" name="group_week[tue_active]" class="checkbox_day tue" value="active"> Tue</label>
        <div class="col-sm-8">
            <?php printHoursSelect("group_week[tue_start]");?> ถึง <?php printHoursSelect("group_week[tue_end]");?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group form-inline">
        <label class="col-sm-3 checkbox"><input type="checkbox" name="group_week[wed_active]" class="checkbox_day wed" value="active"> Wed</label>
        <div class="col-sm-8">
            <?php printHoursSelect("group_week[wed_start]");?> ถึง <?php printHoursSelect("group_week[wed_end]");?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group form-inline">
        <label class="col-sm-3 checkbox"><input type="checkbox" name="group_week[thu_active]" class="checkbox_day thu" value="active"> Thu</label>
        <div class="col-sm-8">
            <?php printHoursSelect("group_week[thu_start]");?> ถึง <?php printHoursSelect("group_week[thu_end]");?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group form-inline">
        <label class="col-sm-3 checkbox"><input type="checkbox" name="group_week[fri_active]" class="checkbox_day fri" value="active"> Fri</label>
        <div class="col-sm-8">
            <?php printHoursSelect("group_week[fri_start]");?> ถึง <?php printHoursSelect("group_week[fri_end]");?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group form-inline">
        <label class="col-sm-3 checkbox"><input type="checkbox" name="group_week[sat_active]" class="checkbox_day sat" value="active"> Sat</label>
        <div class="col-sm-8">
            <?php printHoursSelect("group_week[sat_start]");?> ถึง <?php printHoursSelect("group_week[sat_end]");?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group" style="margin-top: 10px;">
        <label>จำนวนครั้งที่สอน</label>
        <input class="form-control" type="text" id="input-study_count" name="study_count" value="@if(@$post['group_week']){{ $post['group_week']['study_count'] }}@endif">
    </div>
    <div class="form-group">
        <label>วันที่เริ่ม</label>
        <input class="form-control" type="date" id="input-date_start" name="date_start" value="@if(@$post['date_start']){{ $post['date_start'] }}@endif">
        <span class="help-block date_end_text"></span>
        <input type="hidden" name="date_end" id="input-date_end" value="@if(@$post['date_end']){{ $post['date_end'] }}@endif">
    </div>
    <div class="hidden-field"></div>
    <?php
    if(isset($study)){
        $filterStudy = array();
        foreach($study as $key => $value){
            if($value['status']=="move" || $value['status']=="cancel"){
                $filterStudy[] = $value;
            }
        }
        if(count($filterStudy)>0){
    ?>
    <legend>Extra Log <a href="" class="glyphicon glyphicon-inbox toggle-extra"></a></legend>
    <div class="extra-log-block" style="display: none;">
        <?php
        foreach($filterStudy as $key => $value){
            if($value['status']=="move"){
                $ori_start = new DateTime($value['ori_start']);
                $ori_start = $ori_start->format("d F Y");

                $start = new DateTime($value['ori_end']);
                $start = $start->format("d F Y");
                echo <<<HTML
            <p class="extra-move alert alert-info">Move {$ori_start} To {$start}</p>
HTML;
            }
            else if($value['status']=="cancel"){
                $start = new DateTime($value['ori_start']);
                $start = $start->format("d F Y");
                echo <<<HTML
            <p class="extra-cancel alert alert-danger">Cancel {$start}</p>
HTML;
            }
        }?>
    </div>
    <script type="text/javascript">
    $(function(){
        var toggleExtra = 1;
        $('.toggle-extra').click(function(e){
            e.preventDefault();
            if(toggleExtra%2==1){
                $('.extra-log-block').slideDown();
            }else {
                $('.extra-log-block').slideUp();
            }
            toggleExtra++;
        });
    });
    </script>
    <?php }}?>
    <button class="btn btn-primary" type="submit">Submit</button>
    <a class="btn btn-info pull-right" href="javascript:history.back();">Cancel</a>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
<script type="text/javascript">
    $(function(){
        var oldMedia = $('.media');
        $('.field-media').delegate('.reupload-media', 'click', function(e){
            e.preventDefault();
            $('.media-block').html('<input type="file" class="form-control" name="video">');
        });

        var oldData = <?php echo isset($oldData)? json_encode($oldData): 'null'; ?>;
        var inputName = $('#input-name');
        var inputDes = $('#input-description');
        $('.cancle-button').click(function(e){
            e.preventDefault();
            if(oldData==null){
                inputName.val("");
                inputDes.val("");
                $('input[name="picture"]').val('');
            }
            else {
                inputName.val(oldData.name);
                inputDes.val(oldData.description);
                $('.media-block').html('').append(oldMedia);
                $('.field-media').show();
            }
        });
        if(oldData != null){
            (function(){
                var group_week = oldData.group_week;
                $('.checkbox_day.sun').prop("checked", group_week.sun_active==1? true: false);
                $('.checkbox_day.mon').prop("checked", group_week.mon_active==1? true: false);
                $('.checkbox_day.tue').prop("checked", group_week.tue_active==1? true: false);
                $('.checkbox_day.wed').prop("checked", group_week.wed_active==1? true: false);
                $('.checkbox_day.thu').prop("checked", group_week.thu_active==1? true: false);
                $('.checkbox_day.fri').prop("checked", group_week.fri_active==1? true: false);
                $('.checkbox_day.sat').prop("checked", group_week.sat_active==1? true: false);

                $('.selectbox_day[name="group_week[sun_start]"]').val(group_week.sun_start);
                $('.selectbox_day[name="group_week[mon_start]"]').val(group_week.mon_start);
                $('.selectbox_day[name="group_week[tue_start]"]').val(group_week.tue_start);
                $('.selectbox_day[name="group_week[wed_start]"]').val(group_week.wed_start);
                $('.selectbox_day[name="group_week[thu_start]"]').val(group_week.thu_start);
                $('.selectbox_day[name="group_week[fri_start]"]').val(group_week.fri_start);
                $('.selectbox_day[name="group_week[sat_start]"]').val(group_week.sat_start);

                $('.selectbox_day[name="group_week[sun_end]"]').val(group_week.sun_end);
                $('.selectbox_day[name="group_week[mon_end]"]').val(group_week.mon_end);
                $('.selectbox_day[name="group_week[tue_end]"]').val(group_week.tue_end);
                $('.selectbox_day[name="group_week[wed_end]"]').val(group_week.wed_end);
                $('.selectbox_day[name="group_week[thu_end]"]').val(group_week.thu_end);
                $('.selectbox_day[name="group_week[fri_end]"]').val(group_week.fri_end);
                $('.selectbox_day[name="group_week[sat_end]"]').val(group_week.sat_end);

                $('input[name="date_start"]').val(group_week.date_start);
            }());
            $('.checkbox_day, .selectbox_day, #input-study_count, #input-date_start, #input-date_end').prop('disabled', true);
        }else {
            var date_end = null;

            function Date_toYMD(date) {
                var year, month, day;
                year = String(date.getFullYear());
                month = String(date.getMonth() + 1);
                if (month.length == 1) {
                    month = "0" + month;
                }
                day = String(date.getDate());
                if (day.length == 1) {
                    day = "0" + day;
                }
                return year + "-" + month + "-" + day;
            }

            var days_name = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"];
            function calculateDateEnd(){
                var study_count = parseInt($("#input-study_count").val());
                if($('.checkbox_day:checked').size() == 0
                    || isNaN(study_count)
                    || study_count == 0
                    || $('#input-date_start').val() == "")
                {
                    $('.date_end_text').text("");
                    $("#input-date_end").val("");
                    return;
                }

                var date_end = new Date();
                var date_start = new Date($("#input-date_start").val());
                var i=-1;
                var j = study_count;

                var groups_study = [];
                while(j > 0){
                    i++;
                    date_end.setTime(date_start.getTime() + (1000*3600*24*i));
                    var day = days_name[date_end.getDay()];
                    var checkbox = $('.checkbox_day.'+ day);
                    if(checkbox.is(":checked")){
                        groups_study.push({
                            start: Date_toYMD(date_end)+' '+$('.selectbox_day[name="group_week['+day+'_start]"]').val(),
                            end: Date_toYMD(date_end)+' '+$('.selectbox_day[name="group_week['+day+'_end]"]').val()
                        });
                        j--;
                    }
                    if(i > 4000) break;
                }
                $('.hidden-field').html('');
                for(i in groups_study){
                    $('.hidden-field').append('<input type="hidden" name="group_study['+i+'][start]" value="'+groups_study[i].start+'">');
                    $('.hidden-field').append('<input type="hidden" name="group_study['+i+'][end]" value="'+groups_study[i].end+'">');
                }
                $("#input-date_end").val(Date_toYMD(date_end));
                $('.date_end_text').text("*วันสิ้นสุด "+Date_toYMD(date_end));
                console.log($('.create-form').serializeArray());
            }

            $('.checkbox_day').change(function(e){
                e.preventDefault();
                var formGroup = $(this).closest('.form-group');
                if($(this).is(":checked")){
                    $("select", formGroup).prop("disabled", false);
                }else {
                    $("select", formGroup).prop("disabled", true);
                }
                calculateDateEnd();
            });
            $('.checkbox_day').change();

            $("#input-study_count").keyup(function(e){
                calculateDateEnd();
            });

            $("#input-date_start").change(function(e){
                calculateDateEnd();
            });

            $('.create-form').submit(function(e){
                if($("#input-date_end").val()==""){
                    alert("ระบบต้องการการกำหนดข้อมูลวัน-เวลาการสอน");
                    e.preventDefault();
                    return;
                }
            });
        }
    });
</script>
@stop