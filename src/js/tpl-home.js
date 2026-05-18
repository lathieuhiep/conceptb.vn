(function ($) {
    "use strict";

    gsap.registerPlugin(SplitText, ScrollTrigger);

    // Khởi tạo Splide Partners
    const elementPartner = () => {
        const splidePartner = $('.element-partner__splide');
        if (splidePartner.length) {
            splidePartner.each(function () {
                const splide = new Splide(this, {
                    type: 'loop',
                    drag: false,
                    focus: 'center',
                    fixedWidth: '162px',
                    height: '104px',
                    gap: '10rem',
                    arrows: false,
                    pagination: false,
                    autoScroll: { speed: 1, pauseOnHover: false, pauseOnFocus: false },
                    breakpoints: {
                        1199: { gap: '8rem' },
                        991:  { gap: '6rem' },
                        767:  { gap: '4rem' },
                        575:  { gap: '2rem' },
                    }
                });
                splide.mount(window.splide.Extensions);
            });
        }
    };

    // Khởi tạo Gallery
    const elementGroupGallery = () => {
        const splideGroupGallery = $('.element-group-gallery__splide');
        if (splideGroupGallery.length) {
            splideGroupGallery.each(function () {
                const direction = $(this).data('direction');
                const splide = new Splide(this, {
                    type: 'loop',
                    drag: false,
                    focus: 'center',
                    fixedWidth: '408px',
                    height: '306px',
                    gap: '12px',
                    arrows: false,
                    pagination: false,
                    direction: direction,
                    autoScroll: { speed: 1, pauseOnHover: false, pauseOnFocus: false },
                    breakpoints: {
                        1199: {
                            fixedWidth: '360px',
                            height: '270px',
                        },
                        991: {
                            fixedWidth: '320px',
                            height: '240px',
                        },
                        767: {
                            fixedWidth: '260px',
                            height: '195px',
                            gap: '10px',
                        },
                        575: {
                            fixedWidth: '60vw',
                            height: '45vw',
                            gap: '8px',
                        },
                    }
                });
                splide.mount(window.splide.Extensions);
            });
        }
    };

    // Khởi tạo GSAP Services Reveal
    const initServicesReveal = () => {
        const items = gsap.utils.toArray(".element-services__list .item");
        if (items.length === 0) return;

        items.forEach((item) => {
            const icon  = item.querySelector(".item__icon");
            const title = item.querySelector(".item__title");

            if (icon && title) {
                const tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: item,
                        start: "top 80%",
                        end: "bottom 100px",
                        toggleActions: "play none none reverse",
                        invalidateOnRefresh: true,
                    }
                });

                tl.to([icon, title], {
                    clipPath: "inset(0% 0 0 0)",
                    opacity: 1,
                    duration: 0.8,
                    ease: "expo.out",
                    stagger: 0.15
                });
            }
        });
    };

    // Khởi tạo Swiper Project với hiệu ứng Coverflow
    const elementProject = () => {
        const el = document.querySelector('.element-project__swiper');
        if (!el) return;

        new Swiper(el, {
            effect: "coverflow",
            loop: true,
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 1.2,
            coverflowEffect: {
                rotate: 0,
                stretch: 100,
                depth: 100,
                modifier: 2,
                slideShadows: true,
                scale: 0.95,
            },
        });
    };

    // volunteer slider
    const elementVolunteer = () => {
        const el = document.querySelector('.swiper-volunteer');
        if (!el) return;

        new Swiper(el, {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            loop: true,
            coverflowEffect: {
                rotate: 35,
                stretch: -1,
                depth: 0,
                modifier: 1,
                slideShadows: false,
            },
        });
    }

    //
    const initTyping = () => {
        const el = document.querySelector('.typing');
        if (!el) return;

        const split = SplitText.create(el, {
            type: 'chars',
            charsClass: 'char',
            tag: 'span'
        });

        gsap.set(split.chars, { opacity: 0 });

        gsap.to(split.chars, {
            opacity: 1,
            duration: 0.01,
            stagger: 0.06,
            ease: 'back.out(2)',
            scrollTrigger: {
                trigger: el,       // khi el vào viewport
                start: 'top 80%',  // bắt đầu khi top của el đạt 80% chiều cao màn hình
                once: true,        // chỉ chạy 1 lần
            }
        });
    }

    // Xử lý sự kiện click cho nút submit cf7
    $('.element-contact__form .wpcf7-form .action-box__btn p').on('click', function (e) {
        if ($(e.target).is('.wpcf7-submit')) return;

        const btn = $(this).find('.wpcf7-submit');

        if (btn.length) {
            btn[0].click(); // dùng native click
        }

    });

    // Quản lý luồng thực thi khi trang load
    $(window).on('load', function () {
        elementPartner();
        elementGroupGallery();
        initServicesReveal();
        elementProject();
        elementVolunteer();
        initTyping();

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                ScrollTrigger.refresh();
            });

        });
    });

})(jQuery);
