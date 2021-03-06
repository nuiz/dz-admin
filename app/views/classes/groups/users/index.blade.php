<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 16/9/2556
 * Time: 9:42 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<div style="background: white;">
    <table class="table table-bordered table-dz">
        <tr>
            <th>username</th>
            <th>name</th>
            <th>surname</th>
            <th>email</th>
            <th>remove</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->username }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td><a href="<?php echo URL::to("user/detail/{$user->id}");?>">{{ $user->email }}</a></td>
            <td><a class="remove-user-button glyphicon glyphicon-remove" href="{{ URL::to('class/'.$classed->id.'/group/'.$group->id.'/user/remove/'.$user->id) }}"></a></td>
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

        $('.remove-user-button').bind('touchstart click', function(e){
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
    });
</script>
@stop