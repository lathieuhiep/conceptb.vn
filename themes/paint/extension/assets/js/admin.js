(function ($) {
  "use strict";

  $(document).ready(function () {
    const paint_cmb_color_code_type = $('#paint_cmb_color_code_type');
    const group_standard = $('.group-color-code-standard');

    // handle change type color code
    if (paint_cmb_color_code_type.length) {
      paint_cmb_color_code_type.on('change', function () {
        const val = $(this).val();

        if (val === 'standard') {
          group_standard.slideDown();
        } else {
          group_standard.slideUp();
        }
      })
    }
  })

})(jQuery);