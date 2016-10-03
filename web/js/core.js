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

$.extend({
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
    },
});

$.fn.extend({

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
            show($(sel_dep_all));
        } else {
            hide($(sel_dep_all));
            show($(sel_dep));
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
                show(state_dropdown);
                hide(state_text);
                
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
                hide(state_dropdown);
                show(state_text);
            }
        } else {
            hide(state_dropdown);
            hide(state_text);
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

});

})(jQuery);
