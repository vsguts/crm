(function($){

window.yii.app = {}; // Common namespace

var form_group_class = 'form-group';

var select2 = {
    partners: {
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: '', // data-m-url attr
            dataType: 'json',
            cache: true,
            data: function(params){
                var data = {
                    q: params
                };
                if (this.data('mOrganizationsOnly')) {
                    data.organizations = true;
                }

                return data;
            },
            results: function(data){
                return {
                    results: data.partners
                };
            },
            width: 'resolve',
        },
        initSelection: function(element, callback) {
            callback({
                text: element.data('initValueText'),
            });
        },
    },
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

$.extend({

    lastClickedElement: null,

    appCommonInit: function(context) {
        context = $(context || document);

        $('.app-toggle-save', context).each(function(){
            var elm = $(this),
                target_class = elm.data('targetClass'),
                status = $.cookie('app-toggle-' + target_class);
            
            elm.appToggle(!!status);
        });

        $('.app-tabs-save', context).each(function(){
            var elm = $(this),
                selected_href = $.cookie('app-tabs-' + elm.attr('id'));
            
            var href = elm.find('[href="' + selected_href + '"]');
            if (href.is(':visible')) {
                href.click();
            }
        });

        $('.app-dtoggle', context).each(function(){
            $(this).appDToggle();
        });

        $('.app-country', context).each(function(){
            $(this).appCountrySelect();
        });

        $('.app-select2', context).each(function(){
            $(this).appSelect2();
        });

        var elms = $('.app-float-thead', context);
        if (elms.length) {
            elms.floatThead({
                position: 'fixed',
                top: 51,
                zIndex: 500,
            });
        }
    },

    appReflowFloatThead: function() {
        var elms = $('.app-float-thead:not(".floatThead-table")');
        if (elms.length) {
            elms.floatThead('reflow');
        }
    },

});

$.fn.extend({

    appHide: function() {
        this.hide();
        this.find('input, textarea, select').attr('disabled', 'disabled');
    },

    appShow: function() {
        this.show();
        this.find('input, textarea, select').removeAttr('disabled');
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

    appToggle: function(force_status_init) {
        var target_class = this.data('targetClass'),
            toggle_class = this.data('toggleClass'),
            target = $('.' + target_class);

        target.toggle(force_status_init);
        if (toggle_class) {
            this.toggleClass(toggle_class, force_status_init);
        }
        if (this.hasClass('app-toggle-save') && typeof(force_status_init) == 'undefined') {
            if (target.is(':visible')) {
                $.cookie('app-toggle-' + target_class, 1);
            } else {
                $.removeCookie('app-toggle-' + target_class);
            }
        }

    },

    appDToggle: function() {
        var name = matchClass(this, /app-dtoggle-([-\w]+)?/gi).replace('app-dtoggle-', ''),
            value = this.attr('type') == 'checkbox' ? (this.is(':checked') ? 'on' : 'off') : this.val(),
            sel_dep_all = '[class^="app-dtoggle-' + name + '-"',
            sel_dep = '.app-dtoggle-' + name + '-' + value;

        this.find('option').each(function(i, elm){
            var val = $(elm).val();
            if (val != value) {
                sel_dep = sel_dep + ', .app-dtoggle-' + name + '-n' + val;
            }
        });
        
        if (!value && !sel_dep.length) {
            $(sel_dep_all).appShow();
        } else {
            $(sel_dep_all).appHide();
            $(sel_dep).appShow();
        }
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
            width: 'resolve',
        };
        if (this.hasClass('app-select2-partner')) {
            params = select2.partners;
            params.ajax.url = this.data('mUrl');
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
