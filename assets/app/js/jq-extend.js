(function($){

$.extend({

    lastClickedElement: null,

    appCommonInit: function(context) {
        context = $(context || document);

        $('.app-toggle-save', context).each(function(){
            var elm = $(this),
                target_class = elm.data('targetClass'),
                status = !!$.cookie('app-toggle-' + target_class);

            if (elm.hasClass('app-toggle-save-inverse')) {
                status = !status;
            }
            elm.appToggle(status);
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

    modalOpen: function(modal_elm, params) {
        var target = $('#' + params.target_id),
            method = params.method || 'GET';
        delete(params.method);

        if (target.length && !modal_elm.hasClass('app-modal-force')) {
            target.modal({backdrop: true});
        } else {
            if (target.length) {
                target.remove();
            }
            var href = modal_elm.attr('href');
            if (href.length) {
                $.appAjax('request', href, {
                    data: params,
                    type: method,
                    callback: function(data){
                        if (data.html && data.html[params.target_id]) {
                            $(data.html[params.target_id]).modal({backdrop: true});
                            $.appCommonInit($('#' + params.target_id));
                        }
                    }
                });
            }
        }
    }
});

})(jQuery);
