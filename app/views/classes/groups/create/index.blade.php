<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 18/9/2556
 * Time: 13:05 น.
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
    <legend>Create Group</legend>

        <p>
            <label>group name</label>
            <input type="text" class="input-block-level" name="name" value="@if(@$post['name']) {{ $post['name'] }} @endif">
        </p>
        <p>
            <label>description</label>
            <input type="text" class="input-block-level" name="description" value="@if(@$post['description']) {{ $post['description'] }} @endif">
        </p>
        <p class="text-center">
            <button class="btn btn-primary" type="submit">Submit</button>
        </p>
        @if(@$error)
        <p class="alert alert-danger" style="margin-top: 20px;">{{ $error }}</p>
        @endif
</form>
@stop