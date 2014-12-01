(function($){

    function response(options, data) {
        if (data.html) {
            for (var id in data.html) {
                $('#' + id).replaceWith(data.html[id]);
            }
        }
        // TODO: notifications
    };

    var methods = {
        request: function(url, options) {
            options = options || {};
            options.success = function(data, textStatus, jqxhr) {
                response(options, data);
            }
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