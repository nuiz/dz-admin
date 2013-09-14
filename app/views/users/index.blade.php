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
            <td>
                {{ $user->type }}
                @if($user->type == 'normal')
                    <span class="upgrade-button"><i class="glyphicon glyphicon-circle-arrow-up"></i></span>
                @endif
            </td>
            <td><a href="" rel="id_1"><i class="glyphicon glyphicon-edit"></i></a></td>
            <td><a href="" rel="id_1"><i class="glyphicon glyphicon-remove"></i></a></td>
        </tr>
        @endforeach
    </table>
</div>

<script type="text/javascript">
(function($) {
    var IS_IOS = /iphone|ipad/i.test(navigator.userAgent);
    $.fn.nodoubletapzoom = function() {
        if (IS_IOS)
            $(this).bind('touchstart', function preventZoom(e) {
                var t2 = e.timeStamp
                    , t1 = $(this).data('lastTouch') || t2
                    , dt = t2 - t1
                    , fingers = e.originalEvent.touches.length;
                $(this).data('lastTouch', t2);
                if (!dt || dt > 500 || fingers > 1) return; // not double-tap

                e.preventDefault(); // double tap - prevent the zoom
                // also synthesize click events we just swallowed up
                $(this).trigger('click').trigger('click');
            });
    };
})(jQuery);

$(function(){
    $('.upgrade-button').bind('touchstart', function(e){
        dzApi.call({
            method: 'put',
            url: '/user/'+3,
            data: { type: 'member' },
            success: function(data){
                alert(data);
            }
        });
    });

    $('body').nodoubletapzoom();
});
</script>

@stop