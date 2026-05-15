/**
 * Product detail
 */
(function ($) {
    "use strict";

    const body = $('body')

    $(document).ready(function () {
        // galleries
        const sliderProductGalleries = $('.slider-product-galleries')
        const sliderProductGalleryNav = $('.slider-product-gallery-nav')

        if (sliderProductGalleries.length) {
            sliderProductGalleries.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                asNavFor: '.slider-product-gallery-nav'
            })

            const delegateImage = sliderProductGalleries.find('.slick-slide').not('.slick-cloned').find('a')
            sliderProductGalleries.magnificPopup({
                delegate: delegateImage,
                type: 'image',
                gallery:{
                    enabled:true
                }
            })
        }

        if (sliderProductGalleryNav.length) {
            sliderProductGalleryNav.slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: false,
                asNavFor: '.slider-product-galleries',
                dots: false,
                centerMode: false,
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                        }
                    }
                ]
            })
        }

        // handle tabs shown
        const idProduct = parseInt($('.site-single-product').data('product-id'));

        $('.tabs-warp .nav-link').on('shown.bs.tab', function (event) {
            const thisItem = $(this)
            const eventTarget = $(event.target)
            const getIdTab = eventTarget.attr('id')
            const hasSuccessLoading = thisItem.hasClass('success-loading')

            if (!hasSuccessLoading) {
                $.ajax({
                    url: productDetailAjax.url,
                    type: 'POST',
                    data: ({
                        action: 'paint_get_tab_product_detail',
                        idTab: getIdTab,
                        idProduct: idProduct
                    }),
                    beforeSend: function () {
                        $('.spinner-warp').removeClass('d-none');
                    },
                    success: function (result) {
                        if (result) {
                            $(`.${getIdTab}`).append(result)

                            // call masonry
                            if (getIdTab === 'gallery-tab') {
                                const hasCallMasonry = eventTarget.hasClass('success-masonry');

                                if (!hasCallMasonry) {
                                    // Masonry
                                    const productGallery = $('.product-gallery-grid');

                                    if (productGallery.length) {
                                        // int masonry
                                        const $grid = productGallery.masonry({
                                            percentPosition: true,
                                            horizontalOrder: true,
                                            columnWidth: '.grid-sizer-normal',
                                            itemSelector: '.item'
                                        });

                                        // layout Masonry after each image loads
                                        $grid.imagesLoaded().progress(function () {
                                            $grid.masonry('layout');
                                        });
                                    }

                                    eventTarget.addClass('success-masonry');
                                }
                            }

                            // add class success
                            thisItem.addClass('success-loading')
                        }
                    },
                    complete: function () {
                        $('.spinner-warp').addClass('d-none');
                    }
                })
            }
        })

        // handle pattern
        $('.item-pattern').on('click', function () {
            let isLoading = false
            const thisPattern = $(this);
            const postId = thisPattern.data('id');
            const stt = thisPattern.data('stt');
            const hasActive = thisPattern.hasClass('active');

            const spinnerBox = $('.spinner-box');
            const listColor = $('.group-color');

            if (!hasActive && !isLoading) {
                isLoading = true
                thisPattern.closest('.pattern__posts').find('.item-pattern').removeClass('active');
                thisPattern.addClass('active');

                $.ajax({
                    url: productDetailAjax.url,
                    type: 'POST',
                    data: ({
                        action: 'paint_get_color_code',
                        postId: postId
                    }),
                    beforeSend: function () {
                        listColor.empty();
                        spinnerBox.removeClass('d-none');
                    },
                    success: function (result) {
                        thisPattern.closest('.pattern').find('.pattern__style .stt').text(stt);
                        listColor.append(result);
                        spinnerBox.addClass('d-none');
                    },
                    complete: function () {
                        isLoading = false
                    }
                })
            }
        })

        // handle click color product
        body.on('click', '.product-color .item', function () {
            let isLoading = false
            const thisItem = $(this)
            const hasClassActive = thisItem.hasClass('active')
            const itemThumbnail = thisItem.find('.item__thumbnail')

            const groupColorGrid = thisItem.closest('.group-color__grid')
            const idColorCode = groupColorGrid.data('color-code-id')
            const key = itemThumbnail.data('key')

            if ( !hasClassActive && !isLoading ) {
                isLoading = true
                const spinnerBox = thisItem.find('.spinner-load-color')
                const row = thisItem.closest('.list-color')

                groupColorGrid.find('.item').removeClass('active')

                $.ajax({
                    url: productDetailAjax.url,
                    type: 'POST',
                    data: ({
                        action: 'paint_get_color_code_standard',
                        idColorCode: idColorCode,
                        key: key
                    }),
                    beforeSend: function () {
                        thisItem.append('<div class="spinner-load-color">\n' +
                            '<div class="spinner-border text-warning" role="status">\n' +
                            '<span class="visually-hidden">Loading...</span>\n' +
                            '</div>\n' +
                            '</div>')

                        spinnerBox.removeClass('d-none')
                        const boxFullColor = groupColorGrid.find('.box-full-color')

                        if ( boxFullColor.length ) {
                            boxFullColor.slideUp(500, function() {
                                $(this).remove();
                            })
                        }
                    },
                    success: function (result) {
                        if ( $(window).width() > 479 ) {
                            row.after(result)
                        } else {
                            thisItem.after(result)
                        }

                        spinnerBox.addClass('d-none');
                    },
                    complete: function () {
                        thisItem.addClass('active')
                        thisItem.find('.spinner-load-color').remove()

                        groupColorGrid.find('.box-full-color').slideDown(500, function () {
                            $('html, body').animate({
                                scrollTop: groupColorGrid.find('.box-full-color').offset().top - $('.site-header').outerHeight() - 50
                            }, 400);
                        })

                        isLoading = false
                        applyZoomEffect()
                    }
                })
            }
        })

        body.on('click', '.close-full-color', function () {
            const boxFullColorItem = $(this).closest('.box-full-color')

            boxFullColorItem.slideUp(500, function() {
                $(this).remove()
                $('.product-color').find('.list-color .item').removeClass('active')
            })
        })

        // hover image
        const imageContainers = $('.image-container')

        imageContainers.each(function() {
            const container = $(this);
            const img = container.find('img');
            const overlay = container.find('.zoom-overlay');
            const zoomSrc = overlay.data('zoom-src');

            // Cập nhật URL ảnh gốc cho lớp phủ zoom
            overlay.css('background-image', `url(${zoomSrc})`);

            container.on('mousemove', function(e) {
                const rect = img[0].getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // Tính toán vị trí và kích thước của ảnh zoom
                const scale = 2;
                const backgroundX = -(x * scale - overlay.width() / 2);
                const backgroundY = -(y * scale - overlay.height() / 2);

                overlay.css('background-position', `${backgroundX}px ${backgroundY}px`);
            });

            container.on('mouseenter', function() {
                img.css('opacity', '0');
                overlay.css('opacity', '1');
            });

            container.on('mouseleave', function() {
                img.css('opacity', '1');
                overlay.css('opacity', '0');
                overlay.css('background-position', 'center');
            });
        });

        // related product
        const relatedProductGrid = $('.related-product__grid')
        if ( relatedProductGrid.length ) {
            relatedProductGrid.slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                centerMode: false,
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            })
        }
    })

    function showItemFullColor(element, cloneItem, urlImage, thisItem) {
        thisItem.closest('.product-color').find('.item').removeClass('active')

        // append item full color
        element.append('<div class="box-full-color"></div>')

        const findBoxFullColor = body.find('.list-color .box-full-color')
        findBoxFullColor.append(cloneItem)

        findBoxFullColor.find('.item-full img').attr('src', urlImage)
        findBoxFullColor.find('.item-full').removeClass('item')
        findBoxFullColor.find('.info').append('<button class="close-full-color"><i class="fa-solid fa-xmark"></i></button>')
        findBoxFullColor.slideDown()

        thisItem.addClass('active')
    }

    //
    function applyZoomEffect() {
        $('.image-container').each(function() {
            const container = $(this);
            const img = container.find('img');
            const overlay = container.find('.zoom-overlay');
            const zoomSrc = overlay.data('zoom-src');

            // Cập nhật URL ảnh gốc cho lớp phủ zoom
            overlay.css('background-image', `url(${zoomSrc})`);

            // Loại bỏ các sự kiện cũ trước khi gắn lại sự kiện mới
            container.off('mousemove.zoom mouseenter.zoom mouseleave.zoom');

            container.on('mousemove.zoom', function(e) {
                const rect = img[0].getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // Tính toán vị trí và kích thước của ảnh zoom
                const scale = 2;
                const backgroundX = -(x * scale - overlay.width() / 2);
                const backgroundY = -(y * scale - overlay.height() / 2);

                overlay.css('background-position', `${backgroundX}px ${backgroundY}px`);
            });

            container.on('mouseenter.zoom', function() {
                img.css('opacity', '0');
                overlay.css('opacity', '1');
            });

            container.on('mouseleave.zoom', function() {
                img.css('opacity', '1');
                overlay.css('opacity', '0');
                overlay.css('background-position', 'center');
            });
        });
    }
})(jQuery);

document.addEventListener('DOMContentLoaded', (event) => {
    const contentElement = document.getElementById('content-product-detail')

    const simpleBarInstance = new SimpleBar(contentElement, {
        autoHide: false,
        forceVisible: "y"
    })

    // active scroll
    contentElement.classList.add('simplebar-active')

    // Resize
    const resizeObserver = new ResizeObserver(() => {
        simpleBarInstance.recalculate()
    });

    resizeObserver.observe(contentElement);
});
