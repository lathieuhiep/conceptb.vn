(function ($) {
    "use strict";

    $(document).ready(function () {
        const gallery = $('.color-table__grid')

        if ( gallery.length ) {
            gallery.magnificPopup({
                delegate: 'a.img-link',
                type: 'image',
                gallery:{
                    enabled:true
                }
            })
        }
    })
})(jQuery);