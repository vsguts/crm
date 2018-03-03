(function($){

$.extend({

    lastClickedElement: null,

    appCommonInit: function(context) {
        context = $(context || document);

        var elm = $("[data-toggle='tooltip']", context);
        if (elm.length && elm.tooltip) {
            elm.tooltip();
        }

        $('.app-toggle-save', context).each(function(){
            var elm = $(this),
                target_class = elm.data('targetClass'),
                status = !!$.cookie('app-toggle-' + target_class);

            if (elm.hasClass('app-toggle-save-inverse')) {
                status = !status;
            }
            elm.appToggle(status);
        });

        $('.app-dtoggle', context).each(function(){
            $(this).appDToggle();
        });

        $('.app-attr-toggle', context).each(function(){
            $(this).appAttrToggle();
        });

        $('.app-tabs-save', context).each(function(){
            var elm = $(this),
                id = elm.data('tabsId') || elm.attr('id'),
                selected_href = $.cookie('app-tabs-' + id);

            var href = elm.find('[href="' + selected_href + '"]');
            if (href.is(':visible')) {
                href.click();
            }
        });

        $('.app-select2', context).each(function(){
            $(this).appSelect2();
        });

        $('.app-country', context).each(function(){
            $(this).appCountrySelect();
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

    uniqid: function uniqid (prefix, moreEntropy) {
        if (typeof prefix === 'undefined') {
            prefix = '';
        }

        var _formatSeed = function(seed, reqWidth) {
            seed = parseInt(seed, 10).toString(16);
            if (reqWidth < seed.length) {
                return seed.slice(seed.length - reqWidth);
            }
            if (reqWidth > seed.length) {
                return Array(1 + (reqWidth - seed.length)).join('0') + seed;
            }
            return seed;
        };

        var $global = (typeof window !== 'undefined' ? window : GLOBAL);
        $global.$locutus = $global.$locutus || {};
        var $locutus = $global.$locutus;
        $locutus.php = $locutus.php || {};

        if (!$locutus.php.uniqidSeed) {
            $locutus.php.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
        }
        $locutus.php.uniqidSeed ++;

        var retId = prefix;
        retId += _formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
        retId += _formatSeed($locutus.php.uniqidSeed, 5);
        if (moreEntropy) {
            retId += (Math.random() * 10).toFixed(8).toString();
        }

        return retId;
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
