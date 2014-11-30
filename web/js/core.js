(function($){
    
    $(function() {
        $('.m-toggle-save').each(function(){
            var jelm = $(this),
                id = jelm.attr('id'),
                show = $.cookie('m-toggle-' + id),
                obj_id = id.replace(/on_|off_|sw_/, ''),
                obj = $('#' + obj_id);
            
            obj.toggle(!!show);
        });

        $('.m-dtoggle').each(function(){
            dToggle($(this));
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

        if (jelm.hasClass('m-dtoggle')) {
            dToggle(jelm);
        }
    });

    // Private functions

    function dToggle(elm) {
        var name = matchClass(elm, /m-dtoggle-([-\w]+)?/gi).replace('m-dtoggle-', ''),
            value = elm.val(),
            depends_all = $('[class^="m-dtoggle-' + name + '-"'),
            depends_selected = $('.m-dtoggle-' + name + '-' + value);
        
        if (!value && !depends_selected.length) {
            show(depends_all);
        } else {
            hide(depends_all);
            show(depends_selected);
        }
    };

    function hide(elm) {
        elm.hide();
        elm.find('input, textarea').attr('disabled', 'disabled');
    };

    function show(elm) {
        elm.show();
        elm.find('input, textarea').removeAttr('disabled');
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
