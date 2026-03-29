<?php
get_header();

$config_slider_for = [
  'infinite' => true,
  'slidesToShow' => 1,
  'slidesToScroll' => 1,
  'arrows' => false,
  'autoplay' => false,
  'asNavFor' => '.slider-nav'
];

$config_slider_nav = [
  'infinite' => true,
  'slidesToShow' => 4,
  'slidesToScroll' => 1,
  'arrows' => false,
  'autoplay' => false,
  'asNavFor' => '.slider-for',
  'focusOnSelect' => true,
  'responsive' => [
    [
      'breakpoint' => 480,
      'settings' => [
        'slidesToShow' => 3
      ]
    ]
  ],
];
?>

  <div class="site-container site-tool-warp site-single-tool">
    <div class="container">
      <div class="grid-warp <?php echo esc_attr(is_active_sidebar('paint-sidebar-tool') ? 'active-sidebar' : ''); ?>">
        <?php if (is_active_sidebar('paint-sidebar-tool')) : ?>
          <div class="sidebar">
            <?php dynamic_sidebar('paint-sidebar-tool'); ?>
          </div>
        <?php endif; ?>

        <div class="entry-post">
          <?php
          if (have_posts()) :
            while (have_posts()) : the_post();

              $gallery = get_post_meta(get_the_ID(), 'paint_cmb_tool_option_side_gallery', true);
              $url = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_url', true);
              $price = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_price', true);
              $substance = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_substance', true);
              $size = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_size', true);
              $color = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_color', true);
              $weight = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_weight', true);
              ?>
              <div class="entry-post__box">
                <div class="entry-image">
                  <div class="slider-for custom-slick-carousel"
                       data-config-slick='<?php echo wp_json_encode($config_slider_for); ?>'>
                    <div class="image-tool">
                      <?php the_post_thumbnail('large'); ?>
                    </div>

                    <?php foreach ($gallery as $attachment_id => $attachment_url) : ?>
                      <div class="image-tool">
                        <?php echo wp_get_attachment_image($attachment_id, 'large'); ?>
                      </div>
                    <?php endforeach; ?>
                  </div>

                  <div class="slider-nav custom-slick-carousel"
                       data-config-slick='<?php echo wp_json_encode($config_slider_nav); ?>'>
                    <div class="image-tool">
                      <?php the_post_thumbnail('thumbnail'); ?>
                    </div>

                    <?php foreach ($gallery as $attachment_id => $attachment_url) : ?>
                      <div class="image-tool">
                        <?php echo wp_get_attachment_image($attachment_id, 'thumbnail'); ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>

                <div class="entry-content">
                  <h3 class="heading">
                    <?php esc_html_e('Thông số kỹ thuật', 'paint'); ?>
                  </h3>

                  <div class="info">
                    <div class="info__top">
                      <div class="left-box">
                        <h3 class="title">
                          <?php the_title(); ?>
                        </h3>

                        <div class="meta">
                          <?php the_terms(get_the_ID(), 'paint_tool_tag', '', ', '); ?>
                        </div>

                        <div class="money">
                                           <span class="price">
                                               <?php echo esc_html(number_format($price, 0, '', '.')); ?>
                                           </span>
                          <span class="currency">đ</span>
                        </div>
                      </div>

                      <div class="right-box">
                        <a class="icon-image" href="<?php echo esc_url($url); ?>"
                           target="_blank">
                          <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/icon-shopee.png')); ?>"
                               alt="shopee">
                          <span><?php esc_html_e('Mua hàng', 'paint'); ?></span>
                        </a>
                      </div>
                    </div>

                    <ul class="info__middle">
                      <li>
                        <strong><?php esc_html_e('Chất liệu', 'paint'); ?>:</strong>
                        <span><?php echo esc_html($substance); ?></span>
                      </li>

                      <li>
                        <strong><?php esc_html_e('Kích thước dụng cụ', 'paint'); ?>:</strong>
                        <span><?php echo esc_html($size); ?></span>
                      </li>

                      <li>
                        <strong><?php esc_html_e('Màu sắc', 'paint'); ?>:</strong>
                        <span><?php echo esc_html($color); ?></span>
                      </li>

                      <li>
                        <strong><?php esc_html_e('Trọng lượng', 'paint'); ?>:</strong>
                        <span><?php echo esc_html($weight); ?></span>
                      </li>
                    </ul>

                    <div class="info__bottom">
                      <?php the_content(); ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            endwhile;
          endif;
          ?>
        </div>
      </div>

      <?php get_template_part('template-parts/tool/inc', 'related'); ?>
    </div>
  </div>

<?php
get_footer();