<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 19/9/2556
 * Time: 13:49 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<div style="background: white;">
    <table class="table table-bordered table-dz">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>message</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        @foreach($news as $new)
        <tr>
            <td>{{ $new->id }}</td>
            <td>{{ $new->name }}</td>
            <td>{{ $new->message }}</td>
            <td><a class="glyphicon glyphicon-edit" href="{{ URL::to('news/'.$new->id.'/edit') }}"></a></td>
            <td><a class="glyphicon glyphicon-remove" href="{{ URL::to('news/'.$new->id.'/edit') }}"></a></td>
        </tr>
        @endforeach
    </table>
</div>
@stop