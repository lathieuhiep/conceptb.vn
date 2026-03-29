<?php get_header(); ?>

  <div class="site-discover-warp site-single-discover element-spacer-pb">
    <div class="container">
      <div class="grid-layout">
        <?php
        get_template_part('template-parts/discover/inc', 'search-cat');

        get_template_part('template-parts/discover/inc', 'detail');
        ?>
      </div>

      <?php
      $contact_url = paint_get_option('paint_opt_discover_single');

      if ( $contact_url ) :
      ?>
        <div class="link-contact">
          <a href="<?php echo esc_url( paint_get_option('paint_opt_discover_single') ) ?>" target="_blank">
            <?php esc_html_e('NHẬN TƯ VẤN VÀ ĐẶT HÀNG', 'paint'); ?>
          </a>
        </div>
      <?php
      endif;

      get_template_part('template-parts/discover/inc', 'related-post');
      ?>
    </div>
  </div>

<?php
get_footer();