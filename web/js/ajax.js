(function($){

    function response(options, data) {
        if (data.html) {
            for (var id in data.html) {
                $('#' + id).replaceWith(data.html[id]);
            }
        }
        if (data.debug) {
            console.log(data.debug);
        }
        if (options.callback) {
            options.callback(data);
        }
        if (data.scripts) {
            setTimeout(function(){
                $.each(data.scripts, function(i, script){
                    $.globalEval(script);
                });
            }, 1);
        }
        // TODO: notifications
    };

    var methods = {
        request: function(url, options) {
            options = options || {};
            options.success = function(data, textStatus, jqxhr) {
                response(options, data);
            };
            options.error = function(jqxhr, textStatus, errorThrown) {
                console.error(errorThrown);
            };
            return $.ajax(url, options);
        },
    };

    $.cAjax = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else {
            $.error('cAjax: method ' +  method + ' does not exist');
        }
    };

})(jQuery);