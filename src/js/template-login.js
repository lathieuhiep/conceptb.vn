(function ($) {
  "use strict";

  $(document).ready(function () {
    // handle login
    $('#login-form').validate({
      ignore: ":hidden",
      rules: {
        username: {
          required: true
        },
        password: {
          required: true,
        },
      },
      messages: {
        username: {
          required: 'Tên đăng nhập không được để trống'
        },
        password: {
          required: 'Mật khẩu không được để trống'
        },
      },
      submitHandler: function(form) {
        const fromUser = $('.form-user')
        const userName = fromUser.find('#username').val()
        const password = fromUser.find('#password').val()
        const security = fromUser.find('#security').val()
        const url = fromUser.find('.btn-submit-login').data('url')

        $.ajax({
          url: loginAjax.url,
          type: 'POST',
          data: ({
            action: 'paint_login_from',
            username: userName,
            password: password,
            security: security
          }),
          beforeSend: function () {
            $('.spinner-loading').removeClass('d-none')
            $('.txt-error').remove()
          },
          success: function (result) {
            const { success, data } = result

            if (success) {
              document.location.href = url;
            } else {
              fromUser.prepend(`<p class="text-center txt-error">${data.message}</p>`)
            }
          },
          complete: function () {
            $('.spinner-loading').addClass('d-none')
          }
        })

        return false;
      },
    })
  });

})(jQuery);