/**
 * Product detail
 */
(function ($) {
  "use strict";

  $(document).ready(function () {
    // Masonry
    const discoverGallery = $('.grid-discover');

    if (discoverGallery.length) {
      // int masonry
      const $grid = discoverGallery.masonry({
        percentPosition: true,
        horizontalOrder: true,
        columnWidth: '.grid-discover__item',
        itemSelector: '.grid-discover__item'
      });

      // layout Masonry after each image loads
      $grid.imagesLoaded().progress(function () {
        $grid.masonry('layout');
      });
    }

    // handle history back
    $('.history-back-discover').on('click', function (event) {
      event.preventDefault();
      history.back(1);
    })
  });

  // create paged discover
  $(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() + 250 >= $(document).height()) {
      const contentWarpGrid = $('.content-warp');
      const hasScrollLoading = contentWarpGrid.hasClass('scroll-loading');

      if (!hasScrollLoading) {
        contentWarpGrid.addClass('scroll-loading');

        scrollLoadDiscover();
      }

    }
  });

  // function ajax pagination discover
  const gridDiscover = $('.grid-discover')
  const keyword = gridDiscover.data('keyword')
  const limit = gridDiscover.data('limit')
  const cat = gridDiscover.data('cat')
  let paged = 2
  let removeNotice
  const scrollLoadDiscover = () => {
    $.ajax({
      url: discoverAjax.url,
      type: 'POST',
      data: ({
        action: 'paint_pagination_discover',
        keyword: keyword,
        limit: limit,
        cat: cat,
        paged: paged
      }),
      beforeSend: function () {
        $('.spinner-warp').removeClass('d-none');
        clearTimeout(removeNotice);
      },
      success: function (result) {
        if (result) {
          const content = $(result);

          $('.grid-discover').append(content).masonry('appended', content, true);
          $('.content-warp').removeClass('scroll-loading');

          paged++;

        } else {
          $('.content-warp').append('<p class="text-center txt-no-data">Không có bài viết mới</p>')

          removeNotice = setTimeout(function(){
            $('.content-warp').find('.txt-no-data').remove()
          }, 3000);
        }
      },
      complete: function () {
        $('.spinner-warp').addClass('d-none');
      }
    })
  }

})(jQuery);