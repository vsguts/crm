(function($){
    
    $(function(){
        $('.m-toggle-save').each(function(){
            var elm = $(this),
                id = elm.attr('id'),
                show = $.cookie('m-toggle-' + id),
                obj_id = id.replace(/on_|off_|sw_/, ''),
                obj = $('#' + obj_id);
            
            obj.toggle(!!show);
        });
    });

    // Events
    $(document).on('click', function(e) {
        var jelm = $(e.target);

        if (jelm.hasClass('m-toggle') || jelm.parents('.m-toggle').length) {
            var elm = jelm.hasClass('m-toggle') ? jelm : jelm.parents('.m-toggle'),
                id = elm.attr('id'),
                obj_id = id.replace(/on_|off_|sw_/, ''),
                obj = $('#' + obj_id),
                toggle_class = elm.data('toggleClass'),
                save = elm.hasClass('m-toggle-save');

            if (id.indexOf('sw_') == 0) {
                obj.toggle();
                if (toggle_class) {
                    elm.toggleClass(toggle_class);
                }
                if (save) {
                    $.cookie('m-toggle-' + id, obj.is(':visible') ? '1' : '');
                }
            }
        }
    });

    $(document).on('change', function(e) {
        var jelm = $(e.target);

        var elmClass = matchClass(jelm, /m-dtoggle-([-\w]+)?/gi);
        if (elmClass) {
            var name = elmClass.replace('m-dtoggle-', ''),
                value = jelm.val();
            
            hide($('[class^="m-dtoggle-' + name + '-"'));
            show($('.m-dtoggle-' + name + '-' + value));
        }
    });

    function hide(elm) {
        elm.each(function(){
            var e = $(this);
            e.hide();
            e.find('input, textarea').attr('disabled', 'disabled');
        });
    };

    function show(elm) {
        elm.each(function(){
            var e = $(this);
            e.show();
            e.find('input, textarea').removeAttr('disabled');
        });
    };

    function matchClass(elem, str) {
        var jelm = $(elem),
            cls = jelm.attr('class');
        if (typeof(cls) !== 'object' && cls) {
            var result = cls.match(str);
            if (result) {
                return result[0];
            }
        }
    };


})(jQuery);
