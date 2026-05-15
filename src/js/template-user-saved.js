(function ($) {
  "use strict";

  $(document).ready(function () {
    // Masonry
    const gridMasonryWarp = $('.grid-masonry-warp');

    if (gridMasonryWarp.length) {
      // int masonry
      const $grid = gridMasonryWarp.masonry({
        percentPosition: true,
        horizontalOrder: true,
        columnWidth: '.grid-masonry-warp .item',
        itemSelector: '.grid-masonry-warp .item'
      });

      // layout Masonry after each image loads
      $grid.imagesLoaded().progress(function () {
        $grid.masonry('layout');
      });

      $('.tab-user-saved .nav-link').on('shown.bs.tab', function () {
        $grid.masonry()
      })
    }
  })

  // create paged discover
  $(window).scroll(function () {
    if ( $(window).scrollTop() + $(window).height() >= $(document).height() ) {
      const contentWarpGrid = $('.tab-user-saved-content .tab-pane.active');
      const hasScrollLoading = contentWarpGrid.hasClass('scroll-loading');

      if (!hasScrollLoading) {
        const postType = contentWarpGrid.data('post-type')
        contentWarpGrid.addClass('scroll-loading');

        scrollLoadTabUserSaved(postType);
      }

    }
  });

  // function ajax pagination discover
  let paged = 2
  let pagedDiscover = 2;
  let pagedProject = 2;

  const scrollLoadTabUserSaved = (postType) => {
    if ( postType === 'paint_discover' ) {
      paged = pagedDiscover;
    } else {
      paged = pagedProject;
    }

    $.ajax({
      url: templateUserSaveAjax.url,
      type: 'POST',
      data: ({
        action: 'paint_pagination_post_type_user_saved',
        postType: postType,
        paged: paged
      }),
      beforeSend: function () {
        $('.spinner-warp').removeClass('d-none');
      },
      success: function (result) {
        if (result) {
          const content = $(result);

          $('.tab-user-content .tab-pane.active .grid-masonry-warp').append(content).masonry('appended', content, true);
          $('.tab-user-saved-content .tab-pane.active').removeClass('scroll-loading');

          if ( postType === 'paint_discover' ) {
            pagedDiscover++;
          } else {
            pagedProject++;
          }
        }
      },
      complete: function () {
        $('.spinner-warp').addClass('d-none');
      }
    })
  }

})(jQuery)