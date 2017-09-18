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

$(document).on("appCommonInitPost", function(event, context) {

    $('[data-ajax-update="init"]', context).each(function(){
        $(this).appAjaxUpdate();
    });

    $('.app-select2', context).each(function(){
        $(this).appSelect2();
    });

    $('[data-toggle-attr]', context).each(function(){
        $(this).appToggleAttr();
    });

});

$(document).on("change", function(e) {
    var jelm = $(e.target);

    if (jelm.is('[data-ajax-update]')) {
        jelm.appAjaxUpdate();
    }

    if (jelm.is('[data-toggle-attr]')) {
        jelm.appToggleAttr();
    }

});

$(document).on("click", function(e) {
    var jelm = $(e.target);
});

$.fn.extend({

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

    appToggleAttr: function() {
        var object = this.data('toggleAttrObject'),
            attr = this.data('toggleAttr'),
            attrVal = this.data('toggleAttrVal') || true,
            val = this.val(),
            allObjectSelector = '[data-toggle-attr-name="' + object + '"]',
            selectedObjectSelector = '[data-toggle-attr-value="' + val + '"]';
        $(allObjectSelector).removeAttr(attr);
        $(allObjectSelector + selectedObjectSelector).attr(attr, attrVal);
    },

    appAjaxUpdate: function() {
        var param = this.data('param'),
            data = {
                target_id: this.data('targetId')
            };

        if (param) {
            data[param] = this.val();
        }

        $.appAjax('request', this.data('url'), {
            data: data,
            preventScripts: true
        });
    }

});

})(jQuery);
