(function ($) {
  "use strict";

  $(document).ready(function () {
    $('.btn-user-save').on('click', function () {
      const thisBtn = $(this)
      const postId = thisBtn.data('post-id')

      $.ajax({
        url: userSaveAjax.url,
        type: 'POST',
        data: ({
          action: 'paint_user_saved',
          postId: postId
        }),
        beforeSend: function () {
          thisBtn.prop('disabled', true)
          thisBtn.empty().append('<i class="fa-solid fa-circle-notch fa-spin"></i>')
        },
        success:function (response) {
          const success = response.success

          if (success) {
            const data = response.data

            if ( data.status ) {
              thisBtn.empty().append('<i class="fa-solid fa-bookmark"></i>')
            } else {
              thisBtn.empty().append('<i class="fa-regular fa-bookmark"></i>')
            }

          } else {
            thisBtn.empty().append('<i class="fa-regular fa-bookmark"></i>')
          }
        },
        complete: function () {
          thisBtn.prop('disabled', false)
        }
      })
    })
  })

})(jQuery)