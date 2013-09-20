<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 19/9/2556
 * Time: 16:15 น.
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
<form class="create-form" method="post" enctype="multipart/form-data">
    <legend>Create News</legend>
    <div class="form-group">
        <label>news name</label>
        <input type="text" class="form-control" name="name" value="@if(@$attr['name']){{ $attr['name'] }}@endif">
    </div>
    <div class="form-group">
        <label>แนบไฟล์</label>
        <input type="file" class="form-control" name="picture">
    </div>
    <div class="form-group">
        <label>message</label>
        <textarea class="form-control" name="message">@if(@$attr['message']){{ $attr['message'] }}@endif</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    @if(@$error)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error }}</div>
    @endif
</form>
@stop