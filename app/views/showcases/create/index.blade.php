<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 20/9/2556
 * Time: 14:13 น.
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
<form class="add-showcase-form text-center create-form" style="padding: 10px;">
    <label>youube id</label>
    <input type="text" name="youtube_id"
    @if(@$post['youtube_id'])
        value="{{ $post['youtube_id'] }}"
    @endif
    >
    <button type="submit" class="btn btn-primary">add</button>
    @if(@$error_message)
        <div class="alert alert-danger">{{ $error_message }}</div>
    @endif
</form>
@stop