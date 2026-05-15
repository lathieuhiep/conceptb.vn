(function ($) {
    // Hàm kiểm tra nếu phần tử trong khung nhìn
    const isElementInViewport = (element) => {
        const rect = element.getBoundingClientRect(); // Lấy vị trí phần tử
        const windowHeight = window.innerHeight; // Chiều cao cửa sổ

        // Kiểm tra nếu phần tử trong khung nhìn
        return rect.top >= 0 && rect.bottom <= windowHeight;
    }

    // get scope element
    const getScopeElement = (scope) => {
        if (!scope) return document;

        if (window.jQuery && scope instanceof jQuery) {
            return scope[0];
        }

        if (scope.nodeType === 1) {
            return scope;
        }

        return document;
    };

    // setting owlCarousel
    const owlCarouselElementorOptions = (options) => {
        let defaults = {
            loop: true,
            smartSpeed: 800,
            autoplaySpeed: 800,
            navSpeed: 800,
            dotsSpeed: 800,
            dragEndSpeed: 800,
            navText: ['<i class="fa-solid fa-angle-left"></i>','<i class="fa-solid fa-angle-right"></i>'],
        }

        // extend options
        return $.extend(defaults, options)
    }

    // element slider
    const elementSlider = ($scope, $) => {
        const slider = $scope.find('.element-slider__warp')

        if (slider.length) {
            slider.each(function () {
                const thisSlider = $(this)
                const options = slider.data('owl-options')
                options.navText = ['<i class="fa-solid fa-arrow-left-long"></i>','<i class="fa-solid fa-arrow-right-long"></i>']

                thisSlider.owlCarousel(owlCarouselElementorOptions(options))
            })
        }
    }

    // element slider carousel
    const elementSliderCarousel = ($scope, $) => {
        const slider = $scope.find('.element-slider-carousel__warp')

        if (slider.length) {
            slider.each(function () {
                const thisSlider = $(this)
                const options = slider.data('owl-options')

                thisSlider.owlCarousel(owlCarouselElementorOptions(options))
            })
        }
    }

    // element post carousel
    const elementPostCarousel = ($scope, $) => {
        const slider = $scope.find('.element-post-carousel__warp')

        if (slider.length) {
            slider.each(function () {
                const thisSlider = $(this)
                const options = slider.data('owl-options')

                thisSlider.owlCarousel(owlCarouselElementorOptions(options))
            })
        }
    }

    // element about slider
    const elementAboutSlider = ($scope, $) => {
        const slider = $scope.find('.element-about-slider__warp')

        if (slider.length) {
            slider.each(function () {
                const thisSlider = $(this)
                const options = slider.data('owl-options')

                thisSlider.owlCarousel(owlCarouselElementorOptions(options))
            })
        }
    }

    // element tool carousel
    const elementToolSlider = ($scope, $) => {
        const slider = $scope.find('.element-tool-carousel__warp')

        if (slider.length) {
            slider.each(function () {
                const thisSlider = $(this)
                const options = slider.data('owl-options')

                thisSlider.owlCarousel(owlCarouselElementorOptions(options))
            })
        }
    }

    // element project carousel
    const elementProjectSlider = ($scope, $) => {
        const slider = $scope.find('.element-project-carousel__warp')

        if (slider.length) {
            slider.each(function () {
                const thisSlider = $(this)
                const options = slider.data('owl-options')

                thisSlider.owlCarousel(owlCarouselElementorOptions(options))
            })
        }
    }

    // element procedure carousel
    const elementProcedureCarousel = ($scope, $) => {
        const sliderBlock = $scope.find('.element-procedure-carousel')

        if ( sliderBlock.length ) {
            const sliderMain = sliderBlock.find('.procedure-slider-main')
            const sliderNumber = sliderBlock.find('.procedure-slider-number')

            // slider main
            const syncPosition = (el) => {
                const current = el.item.index - el.relatedTarget._clones.length / 2;
                const allItems = $(el.target).find('.owl-item').not('.cloned');
                const thumbItems = sliderNumber.find('.owl-item').not('.cloned');

                allItems.removeClass('current');
                thumbItems.removeClass('current');
                allItems.eq(current).addClass('current');
                thumbItems.eq(current).addClass('current');

                const onScreen = sliderNumber.find('.owl-item.active').length - 1;
                const start = sliderNumber.find('.owl-item.active').first().index();
                const end = sliderNumber.find('.owl-item.active').last().index();

                if (current > end) {
                    sliderNumber.trigger('to.owl.carousel', [current - onScreen, 800]);
                }

                if (current < start) {
                    sliderNumber.trigger('to.owl.carousel', [current, 800]);
                }
            }

            const sliderMainOptions = {
                items: 1,
                autoHeight: true,
                dots: false,
                onChanged: syncPosition
            }

            sliderMain.owlCarousel( owlCarouselElementorOptions( sliderMainOptions ) )

            // slider number
            const sliderNumberOptions = {
                items: 2,
                autoHeight: true,
                dots: false,
                mouseDrag: false,
                touchDrag: false,
                onInitialized: function() {
                    sliderNumber.find('.owl-item').not('.cloned').eq(0).addClass('current')
                }
            }
            sliderNumber.owlCarousel( owlCarouselElementorOptions( sliderNumberOptions ) )

            // custom nav
            const prevBtn = sliderBlock.find('.prev-btn')
            const nextBtn = sliderBlock.find('.next-btn')

            prevBtn.on('click', function() {
                sliderMain.trigger('prev.owl.carousel')
            })

            nextBtn.on('click', function() {
                sliderMain.trigger('next.owl.carousel')
            })
        }
    }

    // element count up
    const elementCountUp = ($scope, $) => {
        let start = 0
        const numberBox = $scope.find('.element-count-up .number-box')

        if ( numberBox.length ) {
            $(window).on('scroll', function() {
                numberBox.each(function () {
                    const thisNumberBox = $(this)

                    if ( isElementInViewport( thisNumberBox[0] ) ) {
                        const countBox = thisNumberBox.find('.count-box')
                        const countTo = countBox.data('number')

                        $({countNum: countBox.text()}).animate(
                            {
                                countNum: countTo
                            },
                            {
                                duration: 850,
                                easing: "swing",
                                step: function () {
                                    countBox.text(
                                        Math.ceil(this.countNum)
                                    );
                                },
                                complete: function () {
                                    countBox.text(
                                        Math.ceil(this.countNum)
                                    );
                                }
                            }
                        )
                    }
                })
            })
        }
    }

    // element code carousel
    const elementColorCodeSlider = ($scope, $) => {
        const slider = $scope.find('.element-color-code-carousel__warp')

        if (slider.length) {
            slider.each(function () {
                const thisSlider = $(this)
                const options = slider.data('owl-options')

                thisSlider.owlCarousel(owlCarouselElementorOptions(options))
            })
        }
    }

    // element image carousel
    const elementImageSlider = ($scope, $) => {
        const slider = $scope.find('.element-image-carousel__warp')

        if (slider.length) {
            slider.each(function () {
                const thisSlider = $(this)
                const options = slider.data('owl-options')

                thisSlider.owlCarousel(owlCarouselElementorOptions(options))
            })
        }
    }

    // marquee splide init
    const initSwiperMarquee = ($scope) => {
        const $container = $scope.find('.element-marquee.swiper');
        if (!$container.length) return;

        // Đọc thông số từ HTML
        const customSpeed = parseInt($container.data('speed')) || 5000;
        const direction = $container.data('direction'); // 'ltr' hoặc 'rtl'

        if ($container.data('my_swiper')) {
            $container.data('my_swiper').destroy(true, true);
        }

        const swiper = new Swiper($container.get(0), {
            loop: true,
            slidesPerView: 6,
            spaceBetween: 24,
            speed: 6000,
            allowTouchMove: false,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
                reverseDirection: (direction === 'ltr'),
            },
            freeMode: {
                enabled: true,
                sticky: false,
                momentum: false,
            },
            resistance: false,
            touchMoveStopPropagation: true,
        });

        $container.data('my_swiper', swiper);
    };

// Đăng ký với Elementor
    $(window).on('elementor/frontend/init', function () {
        /* Element slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-slider.default', elementSlider);

        // element slider carousel
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-slider-carousel.default', elementSliderCarousel);

        // element post carousel
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-post-carousel.default', elementPostCarousel);

        // element about slider
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-about-slider.default', elementAboutSlider);

        // element tool carousel
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-tool-carousel.default', elementToolSlider);

        // element project carousel
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-project-carousel.default', elementProjectSlider);

        // element procedure carousel
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-procedure-carousel.default', elementProcedureCarousel);

        // element count up
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-count-up.default', elementCountUp);

        // element code carousel
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-color-code-carousel.default', elementColorCodeSlider);

        // element image carousel
        elementorFrontend.hooks.addAction('frontend/element_ready/paint-image-carousel.default', elementImageSlider);

        // element marquee splide init
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/paint-marquee.default',
            initSwiperMarquee
        );
    });
})(jQuery);