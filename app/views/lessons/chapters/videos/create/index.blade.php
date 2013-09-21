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
    <legend>Create Video</legend>
    <div class="form-group">
        <label>name</label>
        <input type="text" class="form-control" name="name" value="@if(@$post['name']){{ $post['name'] }}@endif">
    </div>
    <div class="form-group">
        <label>video access</label>
        <div>
            <label class="radio-inline"><input type="radio" name="is_public" value="1" checked>public</label>
            <label class="radio-inline"><input type="radio" name="is_public" value="0">private</label>
        </div>
    </div>
    <div class="form-group">
        <label>video file</label>
        <input type="file" class="form-control" name="video">
    </div>
    <div class="form-group">
        <label>description</label>
        <textarea class="form-control" name="description">@if(@$post['description']){{ $post['description'] }}@endif</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
@stop