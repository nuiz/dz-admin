<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 8/11/2556
 * Time: 15:19 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section("content")
<div style="width: 660px; margin: 0 auto; padding: 10px 0; background: white;">
    <div class="news-block display-block">
        <div>
            <img src="http://61.19.147.72/api/pic/<?php echo $activity->picture_id;?>?display=custom&size_x=640">
        </div>
        <p>
            <?php echo nl2br($activity->message);?>
        </p>
    </div>
    <div class="comment-block display-block">
        <?php foreach($comments as $key => $comment){?>
            <div class="comment-list" data-id="<?php echo $comment->id;?>">
                <div class="pull-left" style="width: 120px;">
                    <img src="http://61.19.147.72/api/user/<?php echo $comment->from->id;?>/picture">
                </div>
                <div class="pull-left" style="width: 520px; padding-left: 20px;">
                    <a class="glyphicon glyphicon-minus-sign delete-button"></a>
                    <h5><a href="<?php echo URL::to("user/detail/{$comment->from->id}");?>"><?php echo $comment->from->username;?></a> <small><?php $dateTime = new DateTime($comment->created_at); echo $dateTime->format("F d");?></small></h5>
                    <p><?php echo $comment->message;?></p>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php }?>
    </div>
</div>
<script type="text/javascript">
$(function(){
    function disabledView(view){
        view.data("disabled", true);
        view.css("opacity", "0.54");
    }

    function enabledView(view){
        view.data("disabled", false);
        view.css("opacity", "");
    }

    $('.delete-button').click(function(e){
        e.preventDefault();
        var view = $(this).closest('.comment-list');
        var id = view.data("id");

        if(view.data("disabled")) return;
        window.confirm("Are you shure for delete that?");
        disabledView(view);
        $.post("<?php echo URL::to("comment/delete");?>/"+id, function(data){
            if(typeof data.error != "undefined"){
                alert(data.error.message);
                enabledView(view);
                return;
            }
            view.fadeOut(function(){
                view.remove();
            });
        }, "json");
    });
});
</script>
@stop