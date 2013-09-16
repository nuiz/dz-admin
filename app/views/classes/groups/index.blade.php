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
            <th>ชื่อกลุ่ม</th>
            <th>จำนวนคนในกลุ่ม</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        @foreach($groups as $group)
        <tr>
            <td>{{ $class->id }}</td>
            <td>{{ $class->name }}</td>
            <td>{{ $class->users->length }}</td>
            <td><a href="#"><i class="glyphicon glyphicon-edit"></i></a></td>
            <td><a href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
        </tr>
        @endforeach
    </table>
</div>

@stop