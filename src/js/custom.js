/**
 * Custom js v1.0.0
 * Copyright 2017-2020
 * Licensed under  ()
 */

(function ($) {
  "use strict";

  $(document).ready(function () {

    /* Start back top */
    $('#back-top').on('click', function (e) {
      e.preventDefault()
      $('html').scrollTop(0)
    })
    /* End back top */

    /* btn mobile Start*/
    let subMenuToggle = $('.sub-menu-toggle')

    if (subMenuToggle.length) {

      subMenuToggle.each(function () {
        $(this).on('click', function () {
          const widthScreen = $(window).width();

          if (widthScreen < 992) {
            $(this).toggleClass('active');
            $(this).closest('.menu-item-has-children').siblings().find(subMenuToggle).removeClass('active');
            $(this).parent().children('.sub-menu').slideToggle();
            $(this).parents('.menu-item-has-children').siblings().find('.sub-menu').slideUp();
          }

        })
      })

    }
    /* btn mobile End */
    
    // show search header
    $('#btn-header-search').on('click', function () {
      $('.search-box-warp').fadeIn().addClass('visible')
      $('.box-action').addClass('hide')
    })

    $('#btn-close-search').on('click', function () {
      $('.search-box-warp').fadeOut().removeClass('visible')
      $('.box-action').removeClass('hide')
    })

    // dropdown account
    const dropUserManager = $('#dropdown-user-manager')

    $('#btn-header-account').click(function(event) {
      event.stopPropagation()

      if ( dropUserManager.hasClass('show')) {
        dropUserManager.removeClass('show').addClass('hide')

        setTimeout(function() {
          dropUserManager.removeClass('hide').hide();
        }, 500)

      } else {
        dropUserManager.removeClass('hide').addClass('show').show();
      }
    })

    $(document).click(function(event) {
      if (!$(event.target).closest('#btn-header-account, #dropdown-user-manager').length) {

        if ( dropUserManager.hasClass('show') ) {
          dropUserManager.removeClass('show').addClass('hide');

          setTimeout(function() {
            dropUserManager.removeClass('hide').hide();
          }, 500)
        }

      }
    })

    /* Start custom owl carousel */
    generalSlickCarousel('.custom-slick-carousel');
    /* End Gallery Single */

  });

  // loading
  $(window).on("load", function () {
    setTimeout(function () {
      $('#site-loadding').remove();
    }, 300);
  })

  // scroll event
  let timer_clear

  $(window).scroll(function () {
    // scroll menu
    const menu = $('.site-header');

    if ($(this).scrollTop() > menu.outerHeight()) {
      menu.addClass('scrolled');
    } else {
      menu.removeClass('scrolled');
    }

    // handle show back to top
    if (timer_clear) clearTimeout(timer_clear);
    timer_clear = setTimeout(function () {

      /* Start scroll back top */
      let $scrollTop = $(this).scrollTop();

      if ($scrollTop > 200) {
        $('#back-top').addClass('active_top');
      } else {
        $('#back-top').removeClass('active_top');
      }
      /* End scroll back top */

    }, 100);


  })

  // function slick carousel
  const generalSlickCarousel = (classSelector) => {
    const sliderCarousel = $(classSelector);

    if (sliderCarousel.length) {
      sliderCarousel.each(function () {
        const slider = $(this);

        if (!slider.hasClass('slick-carousel-init')) {
          const defaults = {
            lazyLoad: 'ondemand',
            speed: 800,
            autoplaySpeed: 2000,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></button>'
          };

          const config = $.extend(defaults, slider.data('config-slick'));

          slider.slick(config).addClass('slick-carousel-init');
        }
      })
    }
  }

})(jQuery);