(function($){

window.yii.app = {}; // Common namespace

var ajaxInProgress = false;

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

$.fn.extend({

    appHide: function() {
        this.hide();
        this.find('input, textarea, select').attr('disabled', 'disabled');
    },

    appShow: function() {
        this.show();
        this.find('input, textarea, select').removeAttr('disabled');
    },

    appToggleDisabling: function(status, disabling) {
        if (disabling) {
            this.each(function(){
                var elm = $(this);
                if (typeof status == 'undefined') {
                    if (elm.is(':visible')) {
                        elm.appHide();
                    } else {
                        elm.appShow();
                    }
                } else {
                    if (status) {
                        elm.appShow();
                    } else {
                        elm.appHide();
                    }
                }
            });
        } else {
            this.toggle(status);
        }
    },

    serializeObject: function()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (typeof(o[this.name]) !== 'undefined' && this.name.indexOf('[]') > 0) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    },

    appToggle: function(display) {
        var target_class = this.data('targetClass'),
            toggle_class = this.data('toggleClass'),
            target = $('.' + target_class),
            disabling = this.data('appDisabling');

        target.appToggleDisabling(display, disabling);
        var status = target.is(':visible');
        $('.' + target_class + '-on').appToggleDisabling(status, disabling);
        $('.' + target_class + '-off').appToggleDisabling(!status, disabling);

        if (toggle_class) {
            this.toggleClass(toggle_class, display);
        }
        if (this.hasClass('app-toggle-save') && typeof(display) == 'undefined') {
            var save = target.is(':visible');
            if (this.hasClass('app-toggle-save-inverse')) {
                save = !save;
            }

            if (save) {
                $.cookie('app-toggle-' + target_class, 1, {path: '/'});
            } else {
                $.removeCookie('app-toggle-' + target_class, {path: '/'});
            }
        }

        $.appReflowFloatThead();
    },

    appToggleComb: function() {
        var prefix = this.data('targetPrefix'),
            status = !this.data('displayStatus'),
            items = $('.app-toggle[data-target-class^="' + prefix + '"]');
        
        items.each(function(){
            $(this).appToggle(status);
        });

        $('.' + prefix + '-on').toggle(status);
        $('.' + prefix + '-off').toggle(!status);

        this.data('displayStatus', status);
    },

    // FIXME: Change class to data attr. @see airtime
    appDToggle: function() {
        var name = matchClass(this, /app-dtoggle-([-\w]+)?/gi).replace('app-dtoggle-', ''),
            value = this.attr('type') == 'checkbox' ? (this.is(':checked') ? 'on' : 'off') : this.val(),
            sel_dep_all = '[class*="app-dtoggle-' + name + '-"]',
            sel_dep = '.app-dtoggle-' + name + '-' + value;

        if (value.length) {
            sel_dep = sel_dep + ', .app-dtoggle-' + name + '-all';
        }

        this.find('option').each(function(i, elm){
            var val = $(elm).val();
            if (val.length && val != value) {
                sel_dep = sel_dep + ', .app-dtoggle-' + name + '-n-' + val;
            }
        });

        $(sel_dep_all).appHide();
        $(sel_dep).appShow();
    },

    appAttrToggle: function() {
        var name = matchClass(this, /app-attr-toggle-([-\w]+)?/gi).replace('app-attr-toggle-', ''),
            value = this.attr('type') == 'checkbox' ? (this.is(':checked') ? 'on' : 'off') : this.val(),
            sel_dep_all = '[class*="app-attr-toggle-' + name + '-"]',
            sel_dep = '.app-attr-toggle-' + name + '-' + value,
            attribute = this.data('appAttrToggle');

        if (value.length) {
            sel_dep = sel_dep + ', .app-attr-toggle-' + name + '-all';
        }

        this.find('option').each(function(i, elm){
            var val = $(elm).val();
            if (val.length && val != value) {
                sel_dep = sel_dep + ', .app-attr-toggle-' + name + '-n-' + val;
            }
        });

        $(sel_dep_all).attr(attribute, 1);
        $(sel_dep).removeAttr(attribute);
    },

    appSelect2: function() {
        var params = {
            width: 'resolve'
        };
        if (this.hasClass('app-select2-ajax')) {
            var config = this.attr('multiple') ? 'commonMultiple' : 'commonSingle';
            var object = this.data('object') || config;
            params = select2ajax[object];
            params.ajax.url = this.data('appUrl');
            if (this.attr('multiple')) {
                params.multiple = this.attr('multiple');
            }
        }
        this.select2(params);
        this.on('change', function(e){
            $.appReflowFloatThead();
        });
    },

    appClone: function(after) {
        var item = this.clone();

        if (after) {
            item.insertAfter(this);
        } else {
            item.insertBefore(this);
        }

        item.find('[id]').each(function(){
            var elm = $(this),
                id = elm.attr('id');
            elm.attr('id', id + 'z');
        });

        // Hash
        var html = item.html().replace(/clonehash[a-z0-9]*/g, 'clonehash' + $.uniqid());
        item.html(html);

        // Select 2 fixes
        item.find('.select2-container').remove();
        item.find('.app-select2').show();

        $.appCommonInit(item);
        return item;
    },

    appSelector: function() {
        var url = this.data('appUrl'),
            delimiter = url.indexOf('?') == -1 ? '?' : '&',
            year = this.val();
        window.location = url + delimiter + 'year=' + year;
    },

    appCheckboxesGroupAllow: function() {
        var all_checkbox = this.find('input[type="checkbox"][value="0"]'),
            selected_checkboxes = this.find('input[type="checkbox"][value!="0"]:checked');
        if (selected_checkboxes.length) {
            all_checkbox.prop('checked', false).prop('disabled', false);
        } else {
            all_checkbox.prop('checked', true).prop('disabled', true);
        }
    },

    appSerializeForm: function() {
        var form = $('#' + this.data('formId')),
            target = $('#' + this.data('targetId'));

        if (form.length && target.length) {
            target.val(form.serialize());
        }
    },

    appFormIsChanged: function() {
        var changed = false;
        if ($(this).hasClass('app-skip-check-items')) {
            return false;
        }
        $(':input:visible', this).each(function() {
            changed = $(this).appFieldIsChanged();

            return !changed;
        });

        return changed;
    },

    appFieldIsChanged: function() {
        var changed = false;
        var self = $(this);
        var dom_elm = self.get(0);
        if (!self.hasClass('cm-item') && !self.hasClass('cm-check-items')) {
            if (self.is('select')) {
                var defaultValue = self.data('appValue') || self.find('option[selected]').val() || '';
                if (defaultValue != self.val()) {
                    changed = true;
                }
            } else if (self.is('input[type=radio], input[type=checkbox]')) {
                if (dom_elm.checked != dom_elm.defaultChecked) {
                    changed = true;
                }
            } else if (self.is('input,textarea')) {
                if (dom_elm.type == 'file' && dom_elm.value == '') {
                    return false;
                }

                if (dom_elm.value != dom_elm.defaultValue) {
                    changed = true;
                }
            }
        }

        return changed;
    },

    appSaveChangedItem: function() {

        var form = this.closest('form'),
            itemElm = this.closest('.app-item'),
            inputs = itemElm.find(':input'),
            changed = false;

        if (ajaxInProgress) {
            return;
        }

        inputs.each(function(){
            if ($(this).appFieldIsChanged()) {
                changed = true;
            }
        });
        if (changed || this.closest('.app-save-changed-items-force').length) {
            var data = inputs.serializeObject();
            var required = form.find('.app-save-required:input, .app-save-required :input');
            if (required.length) {
                data = $.extend(data, required.serializeObject());
            }
            data['target_id'] = this.data('targetId');
            setTimeout(function(){
                ajaxInProgress = true;
                var focusedElementName = $(':focus').attr('name');
                $.appAjax('request', form.attr('action'), {
                    type: form.attr('method') || "post",
                    data: data,
                    callback: function(data) {
                        ajaxInProgress = false;
                        $('[name="'+focusedElementName+'"]').focus();
                    },
                });
            }, 1);
        }
    },

    appCountdown: function() {
        var seconds = this.data('appSeconds'),
            started = this.data('appStarted'),
            targetBox = this.find('.app-countdown-target'),
            secondsBox = this.find('.app-countdown-seconds'),
            messageBox = this.find('.app-countdown-message');
        if (!started) {
            started = Date.now();
            this.data('appStarted', Date.now());
        }
        var callback = function() {
            var passed = (Date.now() - started) / 1000;
            var remind = Math.round(seconds - passed);
            console.log(remind);
            secondsBox.html(remind);
            if (remind <= 0) {
                messageBox.remove();
                targetBox.removeAttr('disabled');
                clearInterval(refreshIntervalId);
            }
        };
        var refreshIntervalId = setInterval(callback, 1000);
        callback();
    }

});

})(jQuery);
