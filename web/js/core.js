(function($){
    
    var form_group_class = 'form-group';

    var modal_options = {
        backdrop: true,
    };

    // Document ready
    $(document).on('ready', function() {
        $('.m-toggle-save').each(function(){
            var elm = $(this),
                target_class = elm.data('targetClass'),
                status = $.cookie('m-toggle-' + target_class);
            
            toggle(elm, !!status);
        });

        $('.m-tabs-save').each(function(){
            var elm = $(this),
                selected_href = $.cookie('m-tabs-' + elm.attr('id'));
            
            elm.find('[href="' + selected_href + '"]').click();
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

        var tabs_save_elm = jelm.parents('.m-tabs-save');
        if (tabs_save_elm.length) {
            var selected = tabs_save_elm.find('.active a');
            $.cookie('m-tabs-' + tabs_save_elm.attr('id'), selected.attr('href'));
        }

        if (jelm.hasClass('c-ajax')) {
            $.cAjax('request', jelm.attr('href'), {
                data: {
                    result_ids: jelm.data('resultIds'),
                },
            });
            return false;
        }

        if (jelm.hasClass('c-modal')) {
            var target_id = jelm.data('targetId'),
                target = $('#' + target_id);
            
            if (target.length) {
                target.modal(modal_options);
            } else {
                var href = jelm.attr('href');
                if (href.length) {
                    $.cAjax('request', href, {
                        data: {
                            result_ids: target_id,
                        },
                        callback: function(data){
                            if (data.html && data.html[target_id]) {
                                $(data.html[target_id]).modal(modal_options);
                            }
                        },
                    });
                }
            }
            return false;
        }
    });
    
    // Rewrite yii events
    $(document).on('click.crm', yii.clickableSelector, function(e) {
        var jelm = $(e.target);

        if (jelm.data('cProcessItems')) {
            var url = jelm.data('url') || jelm.attr('href');
            jelm.data('url', url);
            var obj_name = jelm.data('cProcessItems'),
                url_params = {},
                keys = $('.grid-view').yiiGridView('getSelectedRows');
            
            if (!keys.length) {
                alert(yii.crm.langs['No items selected']);
                e.stopImmediatePropagation();
                return false;
            }
            
            url_params[obj_name] = keys;
            var delimiter = url.indexOf('?') == -1 ? '?' : '&';
            jelm.attr('href', url + delimiter + decodeURIComponent($.param(url_params)));
            return true;
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
            if (target.is(':visible')) {
                $.cookie('m-toggle-' + target_class, 1);
            } else {
                $.removeCookie('m-toggle-' + target_class);
            }
        }

    };

    function dToggle(elm) {
        var name = matchClass(elm, /m-dtoggle-([-\w]+)?/gi).replace('m-dtoggle-', ''),
            value = elm.attr('type') == 'checkbox' ? (elm.is(':checked') ? 'on' : 'off') : elm.val(),
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
        elm.find('input, textarea, select').attr('disabled', 'disabled');
    };

    function show(elm) {
        elm.show();
        elm.find('input, textarea, select').removeAttr('disabled');
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
            state_dropdown = form.find('#' + prefix + 'state_id').parents('.' + form_group_class),
            state_text = form.find('#' + prefix + 'state').parents('.' + form_group_class),
            states = yii.crm.states[country_id];

        if (states) {
            show(state_dropdown);
            hide(state_text);
            
            var select = state_dropdown.find('select');
            select.find('option').remove();
            select.append('<option value=""> -- </option>');
            for (var i in states) {
                select.append('<option value="' + states[i]['id'] + '">' + states[i]['name'] + '</option>');
            }
            
            var select_value = select.data('cValue');
            if (select.find('option[value="' + select_value + '"]').length) {
                select.val(select_value);
            }
        } else {
            hide(state_dropdown);
            show(state_text);
        }
    }

})(jQuery);
