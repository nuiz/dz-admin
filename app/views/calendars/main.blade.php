<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 4/11/2556
 * Time: 16:58 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<?php
function printHoursSelect($name, $default){
    echo '<select name="'.$name.'" class="selectbox_day" value="'.$default.'">';
    $time = "";
    for($i = 0; $i < 48; $i++){
        $time = sprintf("%02s", (int)($i/2));
        $time .= ($i%2==1)? ":30": ":00";
        $timeValue = $time.":00";
        if($default==$timeValue){
            echo '<option value="'.$time.':00" selected>'.$time.'</option>';
        }
        else {
            echo '<option value="'.$time.':00">'.$time.'</option>';
        }
    }
    echo '</select>';
}
?>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.css">
<style type="text/css">
.study-move-style {
    background: #ee8900;
}
.study-cancel-style {
    background: #ee391b;
}
.study-add-style {
    background: #00bd4b;
}
.study-manage-block, .study-add-block {
    position: absolute;
    right: -100%;
    top: 0;
    width: 430px;
    background: #bbbbbb;
    padding: 40px;
    height: 100%;
    z-index: 100;
}
</style>
<div>
    <div style="background: white; padding: 20px; position: relative; overflow: hidden;">
        <div id="calendar" style="width: 666px; margin: 0 auto;"></div>
        <div class="study-manage-block" style="">
            <button class="glyphicon glyphicon-remove close"></button>
            <form class="form-horizontal" role="form">
                <legend>Teach manage</legend>
                <div class="form-group">
                    <label class="col-sm-4 radio control-label"><input type="radio" name="status" class="study-status" value="cancel" checked> Cancel</label>
                    <div class="col-sm-8">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 radio control-label"><input type="radio" name="status" class="study-status" value="move"> Move</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="date" name="study_date"><br />
                        <?php printHoursSelect("start_time", "08:00:00"); ?> ถึง  <?php printHoursSelect("end_time", "16:00:00"); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-8">
                        <button class="btn btn-primary done">Done</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="study-add-block">
            <form class="form-study-create" rol="form">
                <button class="glyphicon glyphicon-remove close"></button>
                <legend>Teach Create</legend>
                <div class="form-group">
                    <label>group</label>
                    <select class="form-control" name="group_id">
                        <?php
                        foreach($groups as $key => $value){
                            echo <<<HTML

                        <option value="{$value['id']}">{$value['class']['name']} {$value['name']}</option>
HTML;

                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>วันเวลา</label>
                    <input class="form-control" type="date" name="study_date"><br />
                    <?php printHoursSelect("start_time", "08:00:00"); ?> ถึง  <?php printHoursSelect("end_time", "16:00:00"); ?>
                </div>
                <button class="btn btn-primary done">Done</button>
            </form>
        </div>
    </div>
</div>

</div>
<script type="text/javascript">
$(function(){
    var events = [];
    var manageBlock = $('.study-manage-block');
    var addBlock = $('.study-add-block');
    $('.close', manageBlock).click(function(e){
        e.preventDefault();
        manageBlock.css({ right: "-100%" });
    });
    $('.close', addBlock).click(function(e){
        e.preventDefault();
        addBlock.css({ right: "-100%" });
    });
    function resetForm(){
        $("input", manageBlock).val("");
        $("input", addBlock).val("");
        $("select", manageBlock).each(function(index, el){
            $(el).val("");
            $(el).val($("option[selected]", el).val());
        });
        $("select", addBlock).each(function(index, el){
            $(el).val("");
            $(el).val($("option[selected]", el).val());
        });
        $("input:radio[name=status]", manageBlock).filter('[value="cancel"]').prop("checked", true);
    }
    $('.done', manageBlock).click(function(e){
        e.preventDefault();
        var objData = manageBlock.data("objData");
        var elView = manageBlock.data("elView");
        var sendData = {};
        sendData.status = $('input[name="status"]:checked', manageBlock).val();
        if(sendData.status=="move"){
            var date = $('input[name="study_date"]', manageBlock).val();
            sendData.start = date + " " + $('select[name="start_time"]', manageBlock).val();
            sendData.end = date + " " + $('select[name="end_time"]', manageBlock).val();
        }
        $('input, select, button', manageBlock).prop('disabled', true);
        $.post("<?php echo URL::to("study/edit");?>" + '/' + objData.id, sendData, function(data){
            $('input, select, button', manageBlock).prop('disabled', false);
            if(typeof data.error != "undefined"){
                alert(data.error.message);
                return;
            }
            objData.status = data.status;
            if(data.status == "move"){
                objData.start = new Date(data.start);
                objData.end = new Date(data.end);
            }
            if(objData.status=="move") objData.className = ["study-move-style"];
            if(objData.status=="cancel") objData.className = ["study-cancel-style"];

            $('#calendar').fullCalendar( 'rerenderEvents' );
            $('.close', manageBlock).click();
            resetForm();
        }, "json");
    });
    $.get("<?php echo URL::to("calendar/data");?>", function(data){
        events = data.data;
        (function(){
            var i = 0;
            for(i in events){
                events[i].title = events[i].group.name;
                events[i].allDay = false;
                if(events[i].status=="move") events[i].className = ["study-move-style"];
                if(events[i].status=="cancel") events[i].className = ["study-cancel-style"];
                if(events[i].status=="add") events[i].className = ["study-add-style"];
            }
        }());

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            eventClick: function(calEvent, jsEvent, view) {
                console.log(calEvent);
                manageBlock.css({ right: "0" });
                manageBlock.data("objData", calEvent);
                manageBlock.data("elView", this);
                resetForm();
                $('input[name="study_date"]', manageBlock).val(new Date(calEvent.start).toJSON().slice(0,10));
                window.ce = calEvent;
                window.je = jsEvent;
                window.vi = view;
                // $(this).css('border-color', 'red');
            },
            events: events
        });
    }, "json");

    $('.add-on-header').click(function(e){
        e.preventDefault();
        addBlock.css({ right: "0" });
        resetForm();
    });

    $('.done', addBlock).click(function(e){
        e.preventDefault();
        var sendData = {};
        var date = $('input[name="study_date"]', addBlock).val();
        var group_id = $('select[name="group_id"]', addBlock).val();

        sendData.start = date + " " + $('select[name="start_time"]', addBlock).val();
        sendData.end = date + " " + $('select[name="end_time"]', addBlock).val();
        $('input, select, button', addBlock).prop('disabled', true);
        $.post("<?php echo URL::to("study/create");?>/" + group_id, sendData, function(data){
            $('input, select, button', addBlock).prop('disabled', false);
            if(typeof data.error != "undefined"){
                alert(data.error.message);
                return;
            }
            var cEvent = data;
            cEvent.title = data.group.name;
            cEvent.allDay = false;
            cEvent.className = ["study-add-style"];
            $("#calendar").fullCalendar( 'renderEvent', cEvent ,true );
            $('.close', addBlock).click();
            resetForm();
        }, "json");
    });
});
</script>
@stop