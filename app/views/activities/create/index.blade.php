<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 21/9/2556
 * Time: 7:23 น.
 * To change this template use File | Settings | File Templates.
 */
?>
@section('content')
<style type="text/css">
    .create-form {
        width: 400px;
        margin: 20px auto;
        background: white;
        border-radius: 4px;
        padding: 20px;
    }
</style>
<form class="create-form" method="post">
    <legend>Create Activity</legend>
    <div class="form-group">
        <label>name</label>
        <input type="text" class="form-control" name="name" value="@if(@$post['name']){{ $post['name'] }}@endif">
    </div>
    <div class="form-group">
        <label>start_time</label>
        <input type="datetime-local" class="form-control" name="start_time" value="@if(@$post['start_time']){{ $post['start_time'] }}@endif">
    </div>
    <div class="form-group">
        <label>message</label>
        <textarea type="text" class="form-control" name="message">@if(@$post['message']){{ $post['message'] }}@endif</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
@stop