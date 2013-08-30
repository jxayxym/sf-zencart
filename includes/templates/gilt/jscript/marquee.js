(function($){
    $.fn.marquee = function(options){
        var _css = {'y-overflow':'scroll',height:'120',width:'300'}
        $.extend(_css, {height:options.height,width:options.width});
        $(this).css(_css);
        $(this).html($(this).html()+$(this).html());
    }
})($);