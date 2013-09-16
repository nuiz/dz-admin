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
    <table class="table">
        <tr>
            <th>id</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>email</th>
            <th>นำออก</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td><a href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
        </tr>
        @endforeach
    </table>
</div>

@stop