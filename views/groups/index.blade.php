<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 12/9/2556
 * Time: 16:22 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')

<div>
    <table>
        <tr>
            <th>id</th>
            <th>ชื่อกลุ่ม</th>
            <th>สมาชิกกลุ่ม</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        @foreach($groups as $group)
        <tr>
            <td>{{ $group->id }}</td>
            <td>{{ $group->name }}</td>
            <td>{{ $group->users->length }}</td>
            <td><i class="glyphicon glyphicon-edit"></i></td>
            <td><i class="glyphicon glyphicon-remove"></i></td>
        </tr>
        @endforeach
    </table>
</div>

@stop