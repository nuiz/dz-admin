/**
 * Created with JetBrains PhpStorm.
 * User: P2DC
 * Date: 11/9/2556
 * Time: 16:48 น.
 * To change this template use File | Settings | File Templates.
 */
var dzApi = (function($){
    function dzApi(){}

    dzApi.host = 'http://localhost:8001';
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
    }
    return new dzApi();
}(jQuery));