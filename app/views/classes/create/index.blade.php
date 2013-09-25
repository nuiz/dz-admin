<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 16/9/2556
 * Time: 16:36 น.
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
    <legend>{{ $headForm }}</legend>
    <label>class name</label>
    <input type="text" name="name" value="@if(@$post->name){{ $post->name }}@endif">
    <button class="btn btn-primary" type="submit">Submit</button>
    @if(@$error)
    <p class="alert alert-danger" style="margin-top: 20px;">{{ $error }}</p>
    @endif
</form>
@stop