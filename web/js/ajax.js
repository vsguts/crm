(function($){

    var spinnerSelector = '[class^="app-ajax-"]';
    var ajaxInProgress = false;

    function response(options, data) {

        $(spinnerSelector).hide();

        if (data.redirect_url) {
            window.location = data.redirect_url;
        }

        if (data.html && !options.appNoInit) {
            for (var id in data.html) {
                $('#' + id).replaceWith(data.html[id]);
                $.appCommonInit($('#' + id));
            }
        }

        if (data.debug) {
            console.log(data.debug);
        }

        if (options.callback) {
            options.callback(data);
        }

        if (data.scripts && !options.preventScripts) {
            setTimeout(function(){
                $.each(data.scripts, function(i, script){
                    $.globalEval(script);
                });
            }, 1);
        }

        if (data.alerts) {
            for (var type in data.alerts) {
                var container = $('.alerts-container'),
                    exists = container.find('.alert-' + type + ':contains(' + data.alerts[type] + ')');
                if (!exists.length) {
                    var text = '<div id="w8-success" class="alert-' + type + ' alert fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.alerts[type] + '</div>';
                    container.append(text);
                }
            }
        }

        $.appReflowFloatThead();

        ajaxInProgress = false;
    }

    var methods = {
        request: function(url, options) {
            ajaxInProgress = true;
            options = options || {};
            options.success = function(data, textStatus, jqxhr) {
                response(options, data);
            };
            options.error = function(jqxhr, textStatus, errorThrown) {
                console.error(errorThrown);
                response(options, {});
            };

            if (!options.hideSpinner) {
                $(spinnerSelector).show();
            }

            return $.ajax(url, options);
        },

        getIsAjaxInProgress: function () {
            return ajaxInProgress;
        }
    };

    $.appAjax = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else {
            $.error('appAjax: method ' +  method + ' does not exist');
        }
    };

})(jQuery);
