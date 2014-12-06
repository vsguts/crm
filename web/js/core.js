(function($){
    
    var form_elm_class = 'form-group';

    $(document).on('ready', function() { // FIXME: need for m-country
        $('.m-toggle-save').each(function(){
            var elm = $(this),
                target_class = elm.data('targetClass'),
                status = $.cookie('m-toggle-' + target_class);
            
            toggle(elm, !!status);
        });

        $('.m-dtoggle').each(function(){
            dToggle($(this));
        });

        $('.m-country').each(function(){
            countrySelect($(this));
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

        if (jelm.hasClass('m-country')) {
            countrySelect(jelm);
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

    function countrySelect(elm)
    {
        var country_id = elm.val(),
            prefix = elm.attr('id').replace('country_id', ''),
            form = elm.parents('form'),
            state_dropdown = form.find('#' + prefix + 'state_id').parents('.' + form_elm_class),
            state_text = form.find('#' + prefix + 'state').parents('.' + form_elm_class),
            states = yii.crm.states[country_id];

        if (states) {
            show(state_dropdown);
            hide(state_text);
            
            var select = state_dropdown.find('select');
            select.find('option').remove();
            select.append('<option value=""> -- </option>');
            for (var state_id in states) {
                select.append('<option value="' + state_id + '">' + states[state_id] + '</option>');
            }
            var select_value = select.data('cValue');
            if (states[select_value]) {
                select.val(select_value);
            }
        } else {
            hide(state_dropdown);
            show(state_text);
        }
    }

})(jQuery);
