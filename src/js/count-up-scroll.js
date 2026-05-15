(function ($) {
    "use strict";

    let start = 0;
    const elementCountUp = $('.element-count-up');

    $(window).scroll(function () {
        // handle count up
        if (elementCountUp.length) {
            const oTop = $('.element-count-up').offset().top - window.innerHeight;

            if (start === 0 && $(window).scrollTop() > oTop) {
                $('.number-counter').each(function () {
                    const $this = $(this);
                    const countTo = $this.attr("data-number");

                    $({countNum: $this.text()}).animate(
                        {
                            countNum: countTo
                        },
                        {
                            duration: 850,
                            easing: "swing",
                            step: function () {
                                $this.text(
                                    Math.ceil(this.countNum)
                                );
                            },
                            complete: function () {
                                $this.text(
                                    Math.ceil(this.countNum)
                                );
                            }
                        }
                    );
                });

                start = 1;
            }
        }
    })
})(jQuery);