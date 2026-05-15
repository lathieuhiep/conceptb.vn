(function ($) {
  "use strict";
  
  $(document).ready(function () {
    const changePasswordForm = $('#change-password-form')
    let errors = {}
    changePasswordForm.validate({
      ignore: ":hidden",
      rules: {
        old_password: {
          required: true,
        },
        password: {
          required: true,
          rangelength: [8, 32],
        },
        password_confirm: {
          rangelength: [8, 32],
          equalTo: "#password"
        }
      },
      messages: {
        old_password: {
          required: 'Mật khẩu cũ không được để trống'
        },
        password: {
          required: 'Mật khẩu không được để trống',
          rangelength: 'Độ dài tối thiểu của mật khẩu là 8 và tối đa là 32 kí tự'
        },
        password_confirm: {
          rangelength: 'Độ dài tối thiểu của mật khẩu là 8 và tối đa là 32 kí tự',
          equalTo: 'Mật khẩu không khớp'
        }
      },
      submitHandler: function (form) {
        $.ajax({
          url: changePasswordAjax.url,
          type: 'POST',
          data: ({
            action: 'paint_change_password',
            formData: $(form).serialize()
          }),
          beforeSend: function () {
            $('.spinner-loading').removeClass('d-none')
          },
          success: function(response) {
            const { success, data } = response

            if (success === true) {
              $('body').append(data)

              const modalChangedPasswordSuccess = new bootstrap.Modal('#modalChangedPasswordSuccess', {
                keyboard: false
              })

              modalChangedPasswordSuccess.show()

            } else {
              const validatorFormCustom = changePasswordForm.validate();
              let customErrors = {}

              $.each(data, function(key, value){
                customErrors[key] = value[0]
              })

              if ( Object.keys(customErrors).length ) {
                validatorFormCustom.showErrors(customErrors)
              }
            }
          },
          complete: function () {
            $('.spinner-loading').addClass('d-none')
          }
        })
      }
    })
  })
  
})(jQuery)