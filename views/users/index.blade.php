@section('content')
<div  style="background: white;">
    <table class="table">
        <tr>
            <th>id</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>email</th>
            <th>ปะเภท</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td field_name="type">
                {{ $user->type }}
                @if($user->type == 'normal')
                    <a class="glyphicon glyphicon-circle-arrow-up upgrade-button" href="{{ URL::to('user/upgrade/'.$user->id) }}"></a>
                @endif
            </td>
            <td><a href="" class="glyphicon glyphicon-edit edit-button"></a></td>
            <td><a href="{{ URL::to('user/delete/'.$user->id) }}" class="glyphicon glyphicon-remove remove-button"></a></td>
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

    $('.upgrade-button').bind('touchstart click', function(e){
        e.preventDefault();

        var tr = $(this).closest('tr');
        if(tr.data('disabled')==true)
            return;

        if(!window.confirm('Are you sure?')){
            return;
        }
        disabledTr(tr);

        var href = $(this).attr('href');
        dzApi.call({
            method: 'post',
            url: href,
            data: { type: 'member' },
            success: function(data){
                if(typeof data.error != 'undefined'){
                    enabledTr(tr);
                    alert(data.error.message);
                    return;
                }

                enabledTr(tr);
                tr.find('td[field_name="type"]').text(data.type);
            }
        });
    });

    $('.remove-button').bind('touchstart click', function(e){
        e.preventDefault();

        var tr = $(this).closest('tr');
        if(tr.data('disabled')==true)
            return;

        if(!window.confirm('Are you sure?')){
            return;
        }
        disabledTr(tr);

        var href = $(this).attr('href');
        dzApi.call({
            method: 'get',
            url: href,
            success: function(data){
                if(typeof data.error != 'undefined'){
                    enabledTr(tr);
                    alert(data.error.message);
                    return;
                }

                tr.fadeOut(function(){
                    tr.remove();
                });
            }
        });
    });

    $('body').nodoubletapzoom();
});
</script>

@stop