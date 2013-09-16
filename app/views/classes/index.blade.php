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
            <th>ชื่อคลาสเรียน</th>
            <th>กลุ่ม</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        @foreach($classes as $class)
        <tr>
            <td>{{ $class->id }}</td>
            <td>{{ $class->name }}</td>
            <td><a href="{{ URL::to('class/'.$class->id.'/group') }}">{{ $class->groups->length }} กลุ่ม</a></td>
            <td><a href="#"><i class="glyphicon glyphicon-edit"></i></a></td>
            <td><a href="#"><i class="glyphicon glyphicon-remove"></i></a></td>
        </tr>
        @endforeach
    </table>
</div>

@stop