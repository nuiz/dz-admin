<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 17/10/2556
 * Time: 10:32 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<form class="form" style="width: 500px; margin: 0 auto; line-height: 30px;">
    <legend>ข้อมูล user</legend>
    <div class="form-group">
        <label>email</label>
        <p>{{ $item->email }}</p>
    </div>
    <div class="form-group">
        <label>phone</label>
        <p>{{ $item->phone_number }}</p>
    </div>
    <div class="form-group">
        <label>email</label>
        <p>{{ $item->email }}</p>
    </div>
    <div class="form-group">
        <label>name</label>
        <div class="form-control-static">{{ $item->name }}</div>
    </div>
</form>