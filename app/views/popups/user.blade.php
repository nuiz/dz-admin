<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 16/10/2556
 * Time: 14:22 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<form class="form" style="width: 500px; margin: 0 auto; line-height: 30px;">
    <legend>ข้อมูล User</legend>
    <div class="form-group">
        <label>username</label>
        <p>{{ $user->username }}</p>
    </div>
    <div class="form-group">
        <label>email</label>
        <p>{{ $user->email_show }}</p>
    </div>
    <div class="form-group">
        <label>phone</label>
        <p>{{ $user->phone_show }}</p>
    </div>
    <div class="form-group">
        <label>type</label>
        <div class="form-control-static">{{ $user->type }}</div>
    </div>
</form>