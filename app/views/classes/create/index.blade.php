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

.color-chose {
    height: 38px;
    border-radius: 6px;
}

.color-choice {
    height: 38px;
    border-radius: 6px;
    margin-top: 10px;
}

.logo-choice {
    float: left;
}
</style>
<form class="create-form" method="post">
    <legend>{{ $headForm }}</legend>
    <div class="form-group">
        <label>name</label>
        <input type="text" name="name" id="input-name" class="form-control" value="@if(@$post->name){{ $post->name }}@endif">
    </div>
    <div class="form-group">
        <label>color</label>
        <input type="hidden" name="color" value="@if(@$post->color){{ $post->color }}@endif">
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
    <div class="form-group">
        <label>logo</label>
        <input type="hidden" name="logo" value="@if(@$post->logo){{ $post->logo }}@endif">
        <div class="logo-chose"></div>
        <div class="logo-list" style="display: none;">
            <div class="logo-choice" logo="01"><img src="{{ URL::to('img/lesson_logo/Dancer01Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="02"><img src="{{ URL::to('img/lesson_logo/Dancer02Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="03"><img src="{{ URL::to('img/lesson_logo/Dancer03Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="04"><img src="{{ URL::to('img/lesson_logo/Dancer04Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="05"><img src="{{ URL::to('img/lesson_logo/Dancer05Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="06"><img src="{{ URL::to('img/lesson_logo/Dancer06Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="07"><img src="{{ URL::to('img/lesson_logo/Dancer07Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="08"><img src="{{ URL::to('img/lesson_logo/Dancer08Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="09"><img src="{{ URL::to('img/lesson_logo/Dancer09Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="10"><img src="{{ URL::to('img/lesson_logo/Dancer10Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="11"><img src="{{ URL::to('img/lesson_logo/Dancer11Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="12"><img src="{{ URL::to('img/lesson_logo/Dancer12Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="13"><img src="{{ URL::to('img/lesson_logo/Dancer13Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="14"><img src="{{ URL::to('img/lesson_logo/Dancer14Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="15"><img src="{{ URL::to('img/lesson_logo/Dancer15Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="16"><img src="{{ URL::to('img/lesson_logo/Dancer16Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="17"><img src="{{ URL::to('img/lesson_logo/Dancer17Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="18"><img src="{{ URL::to('img/lesson_logo/Dancer18Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="19"><img src="{{ URL::to('img/lesson_logo/Dancer19Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="20"><img src="{{ URL::to('img/lesson_logo/Dancer20Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="21"><img src="{{ URL::to('img/lesson_logo/Dancer21Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="22"><img src="{{ URL::to('img/lesson_logo/Dancer22Ip5@2x.png') }}" height="60"></div>
            <div class="logo-choice" logo="23"><img src="{{ URL::to('img/lesson_logo/Dancer23Ip5@2x.png') }}" height="60"></div>
            <div class="clearfix"></div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    <a class="btn btn-info pull-right" href="javascript:history.back();">Cancel</a>
    @if(@$error)
    <p class="alert alert-danger" style="margin-top: 20px;">{{ $error }}</p>
    @endif
</form>
<script type="text/javascript">
    $(function(){
        $('.color-chose').bind('click', function(e){
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
        else {
            var color = $('input[name="color"]').val();
            $('.color-choice[color="'+color+'"]').click();
        }

        $('.logo-chose').bind('click', function(e){
            $('.logo-list').slideDown();
        });

        $('.logo-choice').bind('click', function(e){
            var logo = $(this).attr('logo');
            $('.logo-chose').html($('img', this).clone());
            $('input[name="logo"]').val(logo);
            $('.logo-list').slideUp();
        });

        if($('input[name="logo"]').val()==''){
            $('.logo-choice').first().click();
        }
        else {
            var logo = $('input[name="logo"]').val();
            $('.logo-choice[logo="'+logo+'"]').click();
        }

        var oldData = <?php echo isset($oldData)? json_encode($oldData): 'null'; ?>;
        var inputColor = $('#input-color');
        var inputLogo = $('#input-logo');
        var inputName = $('#input-name');
        $('.cancle-button').click(function(e){
            e.preventDefault();
            if(oldData==null){
                inputColor.val("");
                inputLogo.val("");
                inputName.val("");
            }
            else {
                var color = $('input[name="color"]').val();
                $('.color-choice[color="'+oldData.color+'"]').click();

                var logo = $('input[name="logo"]').val();
                $('.logo-choice[logo="'+oldData.logo+'"]').click();

                inputName.val(oldData.name);
            }
        });
    });
</script>
@stop