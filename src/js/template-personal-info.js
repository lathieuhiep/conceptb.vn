(function ($) {
    "use strict";

    $(document).ready(function () {
        // format number phone
        new Cleave('#phone-number', {
            numericOnly: true,
            blocks: [3, 4, 4],
            delimiter: ''
        });

        // validate form update info
        $('#user-update-form').validate({
            submitHandler: function(form) {
                form.submit();
            },
            rules: {
                date_birth: {
                    regex: "^\\d{4}\\-(0?[1-9]|1[012])\\-(0?[1-9]|[12][0-9]|3[01])$"
                },
                phone_number: {
                    required: true,
                    digits: true,
                    rangelength: [10, 11],
                },
                email: {
                    regex: "^([a-zA-Z0-9_\\.\\-\\+])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$"
                },
            },
            messages: {
                date_birth: {
                    regex: "Ngày sinh không đúng định dạng"
                },
                phone_number: {
                    required: "Số điện thoại không được để trống",
                    digits: "Số điện thoại chỉ nhập số",
                    rangelength: "Số điện thoại độ dài là {0} hoặc {1} số",
                },
                email: {
                    regex: "Email không đúng định dạng"
                },
            }
        })
    })

    // method check regex
    $.validator.addMethod(
      "regex",
      function(value, element, regexp) {
          const re = new RegExp(regexp);

          return this.optional(element) || re.test(value);
      },
      "Không đúng định dạng"
    );
})(jQuery)