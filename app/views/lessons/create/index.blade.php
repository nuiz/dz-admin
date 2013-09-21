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

    .color-chose {
        height: 38px;
        border-radius: 6px;
    }

    .color-choice {
        height: 38px;
        border-radius: 6px;
        margin-top: 10px;
    }
</style>
<form class="create-form" method="post">
    <legend>Create Lesson</legend>
    <div class="form-group">
        <label>name</label>
        <input type="text" class="form-control" name="name" value="@if(@$post['name']){{ $post['name'] }}@endif">
    </div>
    <div class="form-group">
        <label>color</label>
        <input type="hidden" name="color" value="@if(@$post['color']){{ $post['color'] }}@endif">
        <div class="color-chose"></div>
        <div class="color-list" style="display: none;">
            <div class="color-choice" style="background: #9676FF;" color="#9676FF"></div>
            <div class="color-choice" style="background: #B276FF;" color="#B276FF"></div>
            <div class="color-choice" style="background: #D576FF;" color="#D576FF"></div>
            <div class="color-choice" style="background: #FF76F8;" color="#FF76F8"></div>
            <div class="color-choice" style="background: #FF76C7;" color="#FF76C7"></div>
            <div class="color-choice" style="background: #FF7697;" color="#FF7697"></div>
            <div class="color-choice" style="background: #FF7C76;" color="#FF7C76"></div>
            <div class="color-choice" style="background: #FF9076;" color="#FF9076"></div>
            <div class="color-choice" style="background: #FFA476;" color="#FFA476"></div>
            <div class="color-choice" style="background: #FFB876;" color="#FFB876"></div>
            <div class="color-choice" style="background: #FFCA76;" color="#FFCA76"></div>
            <div class="color-choice" style="background: #FFD976;" color="#FFD976"></div>
            <div class="color-choice" style="background: #FFE776;" color="#FFE776"></div>
            <div class="color-choice" style="background: #FFF576;" color="#FFF576"></div>
            <div class="color-choice" style="background: #F1FF76;" color="#F1FF76"></div>
            <div class="color-choice" style="background: #C6FF76;" color="#C6FF76"></div>
            <div class="color-choice" style="background: #9BFF76;" color="#9BFF76"></div>
            <div class="color-choice" style="background: #76FF7B;" color="#76FF7B"></div>
            <div class="color-choice" style="background: #76FFA9;" color="#76FFA9"></div>
            <div class="color-choice" style="background: #76FFDC;" color="#76FFDC"></div>
            <div class="color-choice" style="background: #76EEFF;" color="#76EEFF"></div>
            <div class="color-choice" style="background: #76BBFF;" color="#76BBFF"></div>
            <div class="color-choice" style="background: #768FFF;" color="#768FFF"></div>
            <div class="color-choice" style="background: #7976FF;" color="#7976FF"></div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    @if(@$error_message)
    <div class="alert alert-danger" style="margin-top: 20px;">{{ $error_message }}</div>
    @endif
</form>
<script type="text/javascript">
$(function(){
    $('.color-chose').bind('touchstart click', function(e){
        $('.color-list').slideDown();
    });

    $('.color-choice').bind('click', function(e){
        var color = $(this).attr('color');
        $('.color-chose').css({ background: color });
        $('input[name="color"]').val(color);
        $('.color-list').slideUp();
    });

    if($('input[name="color"]').val()==''){
        $('.color-choice').first().click();
    }
});
</script>
@stop