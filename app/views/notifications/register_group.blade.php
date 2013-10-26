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
        <th>group</th>
        <th>time</th>
        <th>call</th>
    </tr>
    <?php foreach($items as $key => $item){ ?>
    <tr style="<?php if($item->admin_read==1) echo "background: #CCCCCC;";?>">
        <td><?php echo "<a href='".URL::to("popup/reggroup/{$item->id}")."' class='popup-button-fancy fancybox.ajax'>{$item->name}</a>"; ?></td>
        <td><?php echo "{$item->group->class->name} (group: {$item->group->name})";?></td>
        <td><?php $dt = new DateTime($item->created_at); echo $dt->format('d/m/Y');?></td>
        <td class="text-center"><input type="checkbox" class="check-call" data-object_id="{{ $item->id }}" <?php if($item->called==1){ echo "checked"; }?> /></td>
    </tr>
    <?php } ?>
</table>
<script type="text/javascript">
$(function(){
    $.get('<?php echo URL::to('notification/read');?>', { type: "register_group" }, function(data){
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

    $(".check-call").change(function(e){
        var el = $(this);
        var called = $(this).is(":checked")? 1: 0;
        var object_id = $(this).data("object_id");
        $.post("<?php echo URL::to("notification/editreggroup");?>/"+object_id, { called: called }, function(data){
            if(typeof data.error == 'undefined'){
                alert(data.error.message);
                el.prop('checked', !called);
            }
        }, "json");
    });

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