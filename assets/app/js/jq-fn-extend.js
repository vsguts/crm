(function($){

window.yii.app = {}; // Common namespace

var select2ajax = {
    commonSingle: {
        allowClear: true,
        minimumInputLength: 2,
        ajax: {
            url: '', // data-app-url attr
            dataType: 'json',
            cache: true,
            width: 'resolve',
            data: function(params){
                return {
                    q: params
                };
            },
            results: function(data){
                return {
                    results: data.list
                };
            }
        },
        initSelection: function(element, callback) {
            callback({
                text: element.data('initValueText')
            });
        }
    },
    commonMultiple: {
        allowClear: true,
        minimumInputLength: 2,
        ajax: {
            url: '',
            dataType: 'json',
            cache: true,
            width: 'resolve',
            data: function(params){
                return {
                    q: params
                };
            },
            results: function(data){
                return {
                    results: data.list
                };
            }
        },
        initSelection: function(element, callback) {
            callback(element.data('initValueText'));
        }
    }
};

var form_group_class = 'form-group';

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

    appCountrySelect: function() {
        var country_id = this.val(),
            is_required = this.hasClass('app-country-required'),
            prefix = this.attr('id').replace('country_id', ''),
            form = this.parents('form'),
            state_dropdown = form.find('#' + prefix + 'state_id').parents('.' + form_group_class),
            state_text = form.find('#' + prefix + 'state').parents('.' + form_group_class);

        if (country_id || !is_required) {
            var states = yii.app.states[country_id];
            if (states) {
                state_dropdown.appShow();
                state_text.appHide();

                var select = state_dropdown.find('select');
                select.find('option').remove();
                select.append('<option value=""> -- </option>');
                for (var i in states) {
                    select.append('<option value="' + states[i]['id'] + '">' + states[i]['name'] + '</option>');
                }

                var select_value = select.data('appValue');
                if (select.find('option[value="' + select_value + '"]').length) {
                    select.val(select_value);
                }
            } else {
                state_dropdown.appHide();
                state_text.appShow();
            }
        } else {
            state_dropdown.appHide();
            state_text.appHide();
        }
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

    appClone: function() {
        var item = this.clone().insertAfter(this);
        item.find('[id]').each(function(){
            var elm = $(this),
                id = elm.attr('id');
            elm.attr('id', id + 'z');
        });

        //FIXME
        item.find('.select2-container').remove();
        item.find('.app-select2').show();

        $.appCommonInit(item);
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

});

})(jQuery);
