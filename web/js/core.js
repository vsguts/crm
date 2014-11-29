(function($){
    
    $(function(){
        $('.m-toggle-save').each(function(){
            var elm = $(this),
                id = elm.attr('id'),
                show = $.cookie('m-toggle-' + id),
                obj_id = id.replace(/on_|off_|sw_/, ''),
                obj = $('#' + obj_id);
            
            obj.toggle(!!show);
        });
    });

    $(document).on('click', function(e) {
        var jelm = $(e.target);

        if (jelm.hasClass('m-toggle') || jelm.parents('.m-toggle').length) {
            var elm = jelm.hasClass('m-toggle') ? jelm : jelm.parents('.m-toggle'),
                id = elm.attr('id'),
                obj_id = id.replace(/on_|off_|sw_/, ''),
                obj = $('#' + obj_id),
                toggle_class = elm.data('toggleClass'),
                save = elm.hasClass('m-toggle-save');

            if (id.indexOf('sw_') == 0) {
                obj.toggle();
                if (toggle_class) {
                    elm.toggleClass(toggle_class);
                }
                if (save) {
                    $.cookie('m-toggle-' + id, obj.is(':visible') ? '1' : '');
                }
            }
        }
    });

})(jQuery);
