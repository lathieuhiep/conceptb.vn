(function ($) {
  "use strict";

  $(document).ready(function () {
    // format number phone
    new Cleave('#phone-number', {
      numericOnly: true,
      blocks: [3, 4, 4],
      delimiter: ''
    });

    // validate register
    $("#register-form").validate({
      submitHandler: function(form) {
        form.submit();
      },
      onfocusout: false,
      rules: {
        username: {
          required: true,
          regex: "^\\S*$"
        },
        first_name: {
          required: true,
        },
        last_name: {
          required: true,
        },
        phone_number: {
          required: true,
          digits: true,
          rangelength: [10, 11],
        },
        email: {
          regex: "^([a-zA-Z0-9_\\.\\-\\+])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$"
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
        username: {
          required: "Tên đăng nhập không được để trống",
          regex: 'Tên đăng nhập không được có khoảng trắng'
        },
        first_name: {
          required: "Họ không được để trống",
        },
        last_name: {
          required: "Tên không được để trống",
        },
        phone_number: {
          required: "Số điện thoại không được để trống",
          digits: "Số điện thoại chỉ nhập số",
          rangelength: "Số điện thoại độ dài là {0} hoặc {1} số",
        },
        email: {
          regex: "Email không đúng định dạng"
        },
        password: {
          required: 'Mật khẩu không được để trống',
          rangelength: 'Độ dài tối thiểu của mật khẩu là 8 và tối đa là 32 kí tự'
        },
        password_confirm: {
          rangelength: 'Độ dài tối thiểu của mật khẩu là 8 và tối đa là 32 kí tự',
          equalTo: 'Mật khẩu không khớp'
        }
      }
    });
  });

  // method check regex
  $.validator.addMethod(
    "regex",
    function(value, element, regexp) {
      const re = new RegExp(regexp);

      return this.optional(element) || re.test(value);
    },
    "Không đúng định dạng"
  );

})(jQuery);