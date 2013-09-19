/**
 * Created with JetBrains PhpStorm.
 * User: P2DC
 * Date: 11/9/2556
 * Time: 16:48 น.
 * To change this template use File | Settings | File Templates.
 */
var dzApi = (function($){
    function dzApi(){}

    dzApi.prototype.host = '';
    dzApi.prototype.call = function(option){

        var ajaxOption = {};
        var header = {};

        ajaxOption.type = option.method;
        ajaxOption.url = this.host+option.url;

        if(typeof option.data != 'undefined')
            ajaxOption.success = option.success;

        if(typeof option.authToken != 'undefined'){
            header.token = option.authToken;
        }

        ajaxOption.headers = header;
        ajaxOption.dataType = 'json';
        $.ajax(ajaxOption);
    };

    dzApi.prototype.get = function(option){
        var defaultOption = {};
        $.extend(true, $defaultOption, option);

        option.method = 'delete';
        this.call(option);
    };

    dzApi.prototype.post = function(option){
        var defaultOption = {};
        $.extend(true, $defaultOption, option);

        option.method = 'post';
        this.call(option);
    };

    dzApi.prototype.put = function(option){
        var defaultOption = {};
        $.extend(true, $defaultOption, option);

        option.method = 'put';
        this.call(option);
    };

    dzApi.prototype.delete = function(option){
        var defaultOption = {};
        $.extend(true, $defaultOption, option);

        option.method = 'delete';
        this.call(option);
    };
    return new dzApi();
}(jQuery));

/*
var dzTableRow = (function($){
    function dzTableRow(){}
    dzTableRow.prototype.deleteButton = function(button, callback){
        function disabledTr(tr){
            $(tr).css({ opacity: 0.4 });
            $(tr).data('disabled', true);
        }

        function enabledTr(tr)
        {
            $(tr).css({ opacity: 1 });
            $(tr).data('disabled', false);
        }

        $(button).bind('touchstart click', function(e){
            e.preventDefault();

            var tr = $(button).closest('tr');
            if(!window.confirm('Are you sure?')){
                return;
            }
            disabledTr(tr);

            var href = $(this).attr('href');
            $.get(href, function(data){
                if(typeof data.error != 'undefined'){
                    enabledTr(tr);
                    alert(data.error.message);
                    return;
                }
                console.log(data);
                tr.fadeOut(function(){
                    tr.remove();
                });

                if(typeof callback != 'undefined')
                    callback(button, tr);
            }, 'json');
        });
    };

    return new dzTableRow();
}(jQuery));
    */