(function($){

var modal_options = {
    backdrop: true,
};

// Document ready
$(document).on('ready', function() {
    $.mCommonInit();
});

// Events
$(document).on('click', function(e) {
    var jelm = $(e.target);

    if (jelm.hasClass('m-toggle') || jelm.parents('.m-toggle').length) {
        var elm = jelm.hasClass('m-toggle') ? jelm : jelm.parents('.m-toggle');
        elm.mToggle();
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

    var modal_elm = jelm.closest('.c-modal');
    if (modal_elm.length) {
        var target_id = modal_elm.data('targetId'),
            target = $('#' + target_id);
        
        if (target.length && !modal_elm.hasClass('c-modal-force')) {
            target.modal(modal_options);
        } else {
            var href = modal_elm.attr('href');
            if (href.length) {
                $.cAjax('request', href, {
                    data: {
                        result_ids: target_id,
                    },
                    callback: function(data){
                        if (data.html && data.html[target_id]) {
                            $(data.html[target_id]).modal(modal_options);
                            $.mCommonInit($('#' + target_id));
                        }
                    },
                });
            }
        }
        return false;
    }

    // Items
    var _jelm = jelm.closest('.m-item-new');
    if (_jelm.length) {
        var item = _jelm.closest('.m-item'),
            container = item.parent(),
            hidden_item = container.find('.m-item.m-item-hidden');
        
        if (hidden_item.length) {
            hidden_item.removeClass('m-item-hidden');
        } else {
            container.find('.m-item:last').mClone();
        }
    }

    var _jelm = jelm.closest('.m-item-remove');
    if (_jelm.length) {
        var item = _jelm.closest('.m-item'),
            is_text = item.hasClass('m-item-text'),
            items_count = item.parent().find('.m-item').length,
            items_text_count = item.parent().find('.m-item.m-item-text').length,
            items_form_count = items_count - items_text_count;

        if (is_text) {
            if (items_text_count > 1 || !item.parent().find('.m-item-hidden').length) {
                item.remove();
            }
        } else {
            if (items_form_count > 1) {
                item.remove();
            } else if (items_text_count >= 1) {
                item.addClass('m-item-hidden');
            }
        }
    }

    var _jelm = jelm.closest('.m-grid-toggle');
    if (_jelm.length) {
        _jelm.closest('table').find('tr[data-key="' + _jelm.closest('tr').data('key') + '-extra"]').toggle();
        var icon = _jelm.find('.glyphicon');
        if (icon.length) {
            icon.toggleClass('glyphicon-menu-down').toggleClass('glyphicon-menu-up');
        }
        return false;
    }

});

$(document).on('change', function(e) {
    var jelm = $(e.target);

    if (jelm.hasClass('m-dtoggle')) {
        jelm.mDToggle();
    }

    if (jelm.hasClass('m-country')) {
        jelm.mCountrySelect();
    }
});

$(document).on('submit', function(e) {
    var form = $(e.target);
    if (form.hasClass('c-ajax')) {
        $.cAjax('request', form.attr('action'), {
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

// Yii events
$(document).on('beforeValidateAttribute', function(event, obj, msg, deferreds){
    var jeml = $(obj.container);
    if (jeml.find('input,select').attr('disabled')) { // skip validation
        delete obj['validate'];
        return true;
    }
});

})(jQuery);
