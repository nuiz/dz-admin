<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 6/11/2556
 * Time: 10:04 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<div style="background: white; height: 100%; padding: 20px;">
    <form class="form" role="form" style="width: 322px; margin: 0 auto; padding: 20px 20px; border: 1px solid #AAAAAA;">
        <div>
            <a class="delete-button glyphicon glyphicon-remove remove-button pull-right" style="color: red;"></a>
            <div class="text-center">
                <div>
                    <img src="http://61.19.147.72/api/user/{{ $user->id }}/picture">
                </div>
                <div><strong>{{ $user->username }}</strong></div>
            </div>
        </div>
        <div style="margin-top: 20px;">
            <div class="form-group">
                <label>email</label>
                <p>{{ $user->email_show }}</p>
            </div>
            <div class="form-group">
                <label>first name</label>
                <p>{{ $user->first_name }}</p>
            </div>
            <div class="form-group">
                <label>last name</label>
                <p>{{ $user->last_name }}</p>
            </div>

            <div class="form-group">
                <label>phone</label>
                <p>{{ $user->phone_show }}</p>
            </div>
        </div>
        <p class="text-center">
            <a class="btn btn-info" href="javascript: window.dz.userBack();">Back</a>
        </p>
    </form>
</div>
<script type="text/javascript">
$(function(){
    var userId = <?php echo $user->id;?>;
    window.dz = {};
    window.dz.userBack = function(){
        window.history.go(-1);
        setTimeout(function(){
            if(history.length > 1){
                window.location.replace(document.referrer)
            }
            else {
                window.location.replace("<?php echo URL::to("user");?>");
            }
        },1);
    };

    $('.delete-button').click(function(e){
        if($(this).prop('disabled')) return;

        if(!window.confirm("Are you shure for delete that?")){
            return;
        }
        $(this).prop('disabled', true);

        var button = this;
        $.get("<?php echo URL::to("user/delete");?>/"+userId, function(data){
            if(typeof data.error != "undefined"){
                alert(data.error.message);
                $(button).prop('disabled', false);
                return;
            }
            window.dz.userBack();
        }, "json");
    });
});
</script>
@stop