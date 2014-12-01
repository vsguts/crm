(function($){
    
    $(function() {
        $('.m-toggle-save').each(function(){
            var elm = $(this),
                target_class = elm.data('targetClass'),
                status = $.cookie('m-toggle-' + target_class);
            
            toggle(elm, !!status);
        });

        $('.m-dtoggle').each(function(){
            dToggle($(this));
        });
    });

    // Events
    $(document).on('click', function(e) {
        var jelm = $(e.target);

        if (jelm.hasClass('m-toggle') || jelm.parents('.m-toggle').length) {
            var elm = jelm.hasClass('m-toggle') ? jelm : jelm.parents('.m-toggle');
            toggle(elm);
        }
    });

    $(document).on('change', function(e) {
        var jelm = $(e.target);

        if (jelm.hasClass('m-dtoggle')) {
            dToggle(jelm);
        }
    });

    // Private functions

    function toggle(elm, force_status_init) {
        var target_class = elm.data('targetClass'),
            toggle_class = elm.data('toggleClass'),
            target = $('.' + target_class);

        target.toggle(force_status_init);
        if (toggle_class) {
            elm.toggleClass(toggle_class, force_status_init);
        }
        if (elm.hasClass('m-toggle-save') && typeof(force_status_init) == 'undefined') {
            $.cookie('m-toggle-' + target_class, target.is(':visible') ? '1' : '');
        }

    };

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
