(function($){

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
    mCommonInit: function(context) {
        context = $(context || document);

        $('.m-toggle-save', context).each(function(){
            var elm = $(this),
                target_class = elm.data('targetClass'),
                status = $.cookie('m-toggle-' + target_class);
            
            elm.mToggle(!!status);
        });

        $('.m-tabs-save', context).each(function(){
            var elm = $(this),
                selected_href = $.cookie('m-tabs-' + elm.attr('id'));
            
            var href = elm.find('[href="' + selected_href + '"]');
            if (href.is(':visible')) {
                href.click();
            }
        });

        $('.m-dtoggle', context).each(function(){
            $(this).mDToggle();
        });

        $('.m-country', context).each(function(){
            $(this).mCountrySelect();
        });

        $('.m-select2', context).each(function(){
            $(this).mSelect2();
        });
    },
});

$.fn.extend({

    mToggle: function(force_status_init) {
        var target_class = this.data('targetClass'),
            toggle_class = this.data('toggleClass'),
            target = $('.' + target_class);

        target.toggle(force_status_init);
        if (toggle_class) {
            this.toggleClass(toggle_class, force_status_init);
        }
        if (this.hasClass('m-toggle-save') && typeof(force_status_init) == 'undefined') {
            if (target.is(':visible')) {
                $.cookie('m-toggle-' + target_class, 1);
            } else {
                $.removeCookie('m-toggle-' + target_class);
            }
        }

    },

    mDToggle: function() {
        var name = matchClass(this, /m-dtoggle-([-\w]+)?/gi).replace('m-dtoggle-', ''),
            value = this.attr('type') == 'checkbox' ? (this.is(':checked') ? 'on' : 'off') : this.val(),
            sel_dep_all = '[class^="m-dtoggle-' + name + '-"',
            sel_dep = '.m-dtoggle-' + name + '-' + value;

        this.find('option').each(function(i, elm){
            var val = $(elm).val();
            if (val != value) {
                sel_dep = sel_dep + ', .m-dtoggle-' + name + '-n' + val;
            }
        });
        
        if (!value && !sel_dep.length) {
            show($(sel_dep_all));
        } else {
            hide($(sel_dep_all));
            show($(sel_dep));
        }
    },

    mCountrySelect: function() {
        var country_id = this.val(),
            prefix = this.attr('id').replace('country_id', ''),
            form = this.parents('form'),
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
    },

    mSelect2: function() {
        var params = select2.partners;
        params.ajax.url = this.data('mUrl');
        this.select2(params);
    },

    mClone: function() {
        var item = this.clone().insertAfter(this);
        item.find('[id]').each(function(){
            var elm = $(this),
                id = elm.attr('id');
            elm.attr('id', id + 'z');
        });

        //FIXME
        item.find('.select2-container').remove();
        item.find('.m-select2').show();
        
        $.mCommonInit(item);
    },

});

})(jQuery);
