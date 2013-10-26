<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 17/10/2556
 * Time: 10:11 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<table class="table table-bordered table-dz">
    <tr>
        <th>user</th>
        <th>activity</th>
        <th>time</th>
    </tr>
    <?php foreach($items as $key => $item){ ?>
    <tr style="<?php if($item->admin_read==1) echo "background: #CCCCCC;";?>">
        <td><?php echo "<a href='".URL::to("popup/user/{$item->user_id}")."' class='popup-button-fancy fancybox.ajax'>{$item->user->username}</a>";?></td>
        <td><?php echo "{$item->activity->name}";?></td>
        <td><?php $dt = new DateTime($item->created_at); echo $dt->format('d/m/Y');?></td>
    </tr>
    <?php } ?>
</table>
<script type="text/javascript">
$(function(){
    $.get('<?php echo URL::to('notification/read');?>', { type: "user_activity" }, function(data){
        $.get("<?php echo URL::to('notification/count');?>", function(data){
            $(".all-notify-count").text(data.all);
            $(".n-button.reg-upgrade .badge").text(data.register_upgrade);
            $(".n-button.reg-group .badge").text(data.register_group);
            $(".n-button.user-activity .badge").text(data.user_activity);

            if(data.register_upgrade == 0){
                $(".n-button.reg-upgrade .badge").text("");
            }
            if(data.register_group == 0){
                $(".n-button.reg-group .badge").text("");
            }
            if(data.user_activity == 0){
                $(".n-button.user-activity .badge").text("");
            }
        }, "json");
    }, "json");


    $(".popup-button-fancy").fancybox({
        maxWidth	: 800,
        maxHeight	: 600,
        fitToView	: false,
        width		: '70%',
        height		: '70%',
        autoSize	: false,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
    });
});
</script>