(function($){

var modal_options = {
    backdrop: true,
};

// Document ready
$(document).on('ready', function() {
    $.appCommonInit();
});

// Events
$(document).on('click', function(e) {
    var jelm = $(e.target);

    if (jelm.hasClass('app-toggle') || jelm.parents('.app-toggle').length) {
        var elm = jelm.hasClass('app-toggle') ? jelm : jelm.parents('.app-toggle');
        elm.appToggle();
    }

    var tabs_save_elm = jelm.parents('.app-tabs-save');
    if (tabs_save_elm.length) {
        var selected = tabs_save_elm.find('.active a');
        $.cookie('app-tabs-' + tabs_save_elm.attr('id'), selected.attr('href'));
    }

    if (jelm.hasClass('app-ajax')) {
        $.appAjax('request', jelm.attr('href'), {
            data: {
                target_id: jelm.data('targetId'),
            },
        });
        return false;
    }

    var modal_elm = jelm.closest('.app-modal');
    if (modal_elm.length) {
        var target_id = modal_elm.data('targetId'),
            target = $('#' + target_id);
        
        if (target.length && !modal_elm.hasClass('app-modal-force')) {
            target.modal(modal_options);
        } else {
            var href = modal_elm.attr('href');
            if (href.length) {
                $.appAjax('request', href, {
                    data: {
                        target_id: target_id,
                    },
                    callback: function(data){
                        if (data.html && data.html[target_id]) {
                            $(data.html[target_id]).modal(modal_options);
                            $.appCommonInit($('#' + target_id));
                        }
                    },
                });
            }
        }
        return false;
    }

    // Items
    var elm = jelm.closest('.app-item-new');
    if (elm.length) {
        var item = elm.closest('.app-item'),
            container = item.parent(),
            hidden_item = container.find('.app-item.app-item-hidden');
        
        if (hidden_item.length) {
            hidden_item.removeClass('app-item-hidden');
        } else {
            container.find('.app-item:last').appClone();
        }
    }

    var elm = jelm.closest('.app-item-remove');
    if (elm.length) {
        var item = elm.closest('.app-item'),
            is_text = item.hasClass('app-item-real'),
            items_count = item.parent().find('.app-item').length,
            items_text_count = item.parent().find('.app-item.app-item-real').length,
            items_form_count = items_count - items_text_count;

        if (is_text) {
            if (items_text_count > 1 || !item.parent().find('.app-item-hidden').length) {
                item.remove();
            }
        } else {
            if (items_form_count > 1) {
                item.remove();
            } else if (items_text_count >= 1) {
                item.addClass('app-item-hidden');
            }
        }
    }

    var elm = jelm.closest('.table-highlighted > tbody > tr');
    if (elm.length) {
        if (elm.hasClass('highlighted')) {
            elm.removeClass('highlighted');
        } else {
            elm.closest('.table-highlighted').find('tr.highlighted').removeClass('highlighted');
            elm.addClass('highlighted');
        }
    }

    // Grid
    var elm = jelm.closest('.app-grid-toggle');
    if (elm.length) {
        elm.closest('table').find('tr[data-key="' + elm.closest('tr').data('key') + '-extra"]').toggle();
        var icon = elm.find('.glyphicon');
        if (icon.length) {
            icon.toggleClass('glyphicon-menu-down').toggleClass('glyphicon-menu-up');
        }
        return false;
    }

});

$(document).on('change', function(e) {
    var jelm = $(e.target);

    if (jelm.hasClass('app-dtoggle')) {
        jelm.appDToggle();
    }

    if (jelm.hasClass('app-country')) {
        jelm.appCountrySelect();
    }
});

$(document).on('submit', function(e) {
    var form = $(e.target);
    if (form.hasClass('app-ajax')) {
        $.appAjax('request', form.attr('action'), {
            type: "post",
            data: form.serialize(),
            callback: function() {
                if (form.data('cModal')) {
                    $('#' + form.data('cModal')).modal('hide');
                }
            },
        });
        return false;
    }
});


/**
 * Rewrite Yii events
 */
$(document).on('click.app', yii.clickableSelector, function(e) {
    var jelm = $(e.target);

    if (jelm.data('appProcessItems')) {
        var url = jelm.data('url') || jelm.attr('href');
        jelm.data('url', url);
        var obj_name = jelm.data('appProcessItems'),
            url_params = {},
            keys = $('.grid-view').yiiGridView('getSelectedRows');
        
        if (!keys.length) {
            alert(yii.app.langs['No items selected']);
            e.stopImmediatePropagation();
            return false;
        }
        
        url_params[obj_name] = keys;
        var delimiter = url.indexOf('?') == -1 ? '?' : '&';
        jelm.attr('href', url + delimiter + decodeURIComponent($.param(url_params)));
        return true;
    }
});

// Yii events
$(document).on('beforeValidateAttribute', function(event, obj, msg, deferreds){
    var jeml = $(obj.container);
    if (jeml.find('input,select').attr('disabled')) { // skip validation
        delete obj['validate'];
        return true;
    }
});

})(jQuery);
