(function($){

// Document ready
    $(document).ready(function() {
        setTimeout(function(){
            $.appCommonInit();

            // Open modal
            var hash = window.location.hash.replace('#', '');
            if (hash.length) {
                var elm = $('[data-target-id="'+hash+'"]');
                if (elm.length) {
                    elm.first().click();
                }
            }
        }, 0);
    });

// Events
    $(document).on('click', function(e) {
        var jelm = $(e.target);

        $.lastClickedElement = jelm;

        var elm = jelm.closest('.app-click');
        if (elm.length) {
            if (elm.data('target-id')) {
                $('#' + elm.data('target-id')).click();
            }
        }

        var elm = jelm.closest('.app-toggle');
        if (elm.length) {
            elm.appToggle();
        }

        var elm = jelm.parents('.app-tabs-save');
        if (elm.length) {
            var selected = elm.find('.active a'),
                id = elm.data('tabsId') || elm.attr('id');
            $.cookie('app-tabs-' + id, selected.attr('href'), {path: '/'});
        }

        if (jelm.hasClass('app-ajax')) {
            $.appAjax('request', jelm.attr('href'), {
                method: jelm.data('appMethod') || 'get',
                data: {
                    target_id: jelm.data('targetId'),
                },
            });
            return false;
        }

        var modal_elm = jelm.closest('.app-modal');
        if (modal_elm.length) {
            $.modalOpen(modal_elm, {target_id: modal_elm.data('targetId')});
            return false;
        }

        // Items
        var elm = jelm.closest('.app-item-new');
        if (elm.length) {
            var container = elm.closest('.app-item').parent();
            var template = container.find('.app-item.app-item-template:last');
            if (template.length) {
                template.appClone().removeClass('app-item-template');
            } else {
                container.find('.app-item:last').appClone(true);
            }
        }

        var elm = jelm.closest('.app-item-remove');
        if (elm.length) {
            var item = elm.closest('.app-item'),
                container = item.parent();
            if (container.find('.app-item').length > 1) {
                var removedItemsElm = item.closest('form').find('.app-items-removed');
                var idElm = item.find('.app-item-id');
                if (removedItemsElm.length && idElm.length) {
                    var removedValue = removedItemsElm.val();
                    removedValue = removedValue.length ? removedValue.split(',') : [];
                    removedValue.push(idElm.val());
                    removedItemsElm.val(removedValue.join(','));
                }
                item.remove();
                if (container.find('.app-item').length == 1) { // Last item was removed
                    container.find('.app-item.app-item-template:last').appClone().removeClass('app-item-template');
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

        // Bootstrap fixes

        if (jelm.closest('[data-dismiss="alert"]').length) {
            setTimeout(function() {
                $.appReflowFloatThead();
            }, 150);
        }

    });

    $(document).on('change', function(e) {
        var jelm = $(e.target);

        if (jelm.hasClass('app-dtoggle')) {
            jelm.appDToggle();
        }

        if (jelm.hasClass('app-attr-toggle')) {
            jelm.appAttrToggle();
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

    $(window).on('beforeunload', function(e) {
        var celm = $.lastClickedElement;
        if (
            $('form.app-check-changes').appFormIsChanged()
            && (
                celm === null
                || (celm && !celm.is('[type=submit]'))
            )
        ) {
            return yii.app.langs['Your changes have not been saved.'];
        }
    });


    /**
     * Rewrite Yii events
     */

// Click
    $(document).on('click.app', yii.clickableSelector, function(e) {
        var jelm = $(e.target);

        if (jelm.data('appProcessItems')) {
            var url = jelm.data('url') || jelm.attr('href');
            jelm.data('url', url);
            var obj_name = jelm.data('appProcessItems'),
                url_params = {},
                target_id = jelm.data('targetId'),
                method = jelm.data('method'),
                confirm = jelm.data('confirm'),
                keys = $('.grid-view').yiiGridView('getSelectedRows');

            if (!keys.length) {
                alert(yii.app.langs['No items selected']);
                e.stopImmediatePropagation();
                return false;
            }

            if (confirm && !window.confirm(confirm)) {
                e.stopImmediatePropagation();
                return false;
            }

            if (/(post)/i.test(method)) {
                var params = {};
                params[obj_name] = keys;

                if (target_id) {
                    var modal_elm = jelm.closest('.app-modal');
                    $.modalOpen(modal_elm, {ids: keys, target_id: target_id, method: 'POST'});
                } else {
                    $.sendForm(url, params);
                }
                e.stopImmediatePropagation();
                return false;
            }

            url_params[obj_name] = keys;
            var delimiter = url.indexOf('?') == -1 ? '?' : '&';
            jelm.attr('href', url + delimiter + decodeURIComponent($.param(url_params)));
            return true;
        }
    });

// Form validation
    $(document).on('beforeValidateAttribute', function(event, obj, msg, deferreds){
        var jeml = $(obj.container);
        if (jeml.find('input,select').attr('disabled')) { // skip validation
            delete obj['validate'];
            return true;
        }
    });

// Validating form that has tabs inside of it. Automatically switch to tab where validation error persists.
    $(document).on('afterValidate', function (event) {
        if(!$.appAjax('getIsAjaxInProgress')) {
            var form = $(event.target);
            var tabElem = form.find('div.tab-content');
            if (tabElem.length) {
                var elem = form.find('[aria-invalid="true"]').first();
                if (elem.length) {
                    var tabPane = $('#' + elem.attr('id')).closest('div.tab-pane');
                    if (tabPane.length) {
                        $('a[href="#' + tabPane.attr('id') + '"]').click();
                    }
                }
            }
        }
    });

})(jQuery);
