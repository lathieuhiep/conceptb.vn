<?php
$opt_cat = paint_get_option('template_home_opt_tool_cat', '');
$opt_limit = paint_get_option('template_home_opt_tool_limit', 10);
$opt_order_by = paint_get_option('template_home_opt_tool_order_by', 'id');
$opt_order = paint_get_option('template_home_opt_tool_order', 'DESC');

$data_settings_slide = [
  'infinite' => true,
  'slidesToShow' => 4,
  'slidesToScroll' => 1,
  'arrows' => true,
  'autoplay' => false,
  'responsive' => [
    [
      'breakpoint' => 1199,
      'settings' => [
        'slidesToShow' => 4,
        'slidesToScroll' => 4,
        'arrows' => false,
        'dots' => true
      ]
    ],
    [
      'breakpoint' => 767,
      'settings' => [
        'slidesToShow' => 3,
        'slidesToScroll' => 3,
        'arrows' => false,
        'dots' => true
      ]
    ],
    [
      'breakpoint' => 575,
      'settings' => [
        'slidesToShow' => 2,
        'slidesToScroll' => 2,
        'arrows' => false,
        'dots' => true
      ]
    ]
  ],
];

$tax_query = array();
if ($opt_cat) {
  $tax_query = array(
    array(
      'taxonomy' => 'paint_tool_cat',
      'field' => 'term_id',
      'terms' => $opt_cat
    ),
  );
}

$args = array(
  'post_type' => 'paint_tool',
  'posts_per_page' => $opt_limit,
  'orderby' => $opt_order_by,
  'order' => $opt_order,
  'ignore_sticky_posts' => 1,
  'tax_query' => $tax_query
);

$query = new WP_Query($args);

if ($query->have_posts()) :
  ?>

  <div class="element-tool element-tool-slider">
    <div class="tool-list-grid custom-slick-carousel"
         data-config-slick='<?php echo wp_json_encode($data_settings_slide); ?>'>
      <?php
      while ($query->have_posts()):
      $query->the_post();

      $url_product = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_url', true);
      $price = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_price', true);
      ?>

      <div class="item">
        <div class="item__thumbnail">
          <a class="icon-image" href="<?php echo esc_url($url_product); ?>" target="_blank">
            <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/icon-shopee.png')); ?>"
                 alt="shopee">
          </a>

          <?php the_post_thumbnail('large'); ?>
        </div>

        <div class="item__info<?php echo esc_attr(has_term('', 'paint_tool_tag') ? ' align-items-center' : ''); ?>"
        ">
        <div class="left-box">
          <h2 class="title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title() ?>">
              <?php the_title(); ?>
            </a>
          </h2>

          <?php if (has_term('', 'paint_tool_tag')) : ?>
            <div class="meta">
              <?php the_terms(get_the_ID(), 'paint_tool_tag', '', ', '); ?>
            </div>
          <?php endif; ?>
        </div>

        <div class="right-box">
          <span class="price"><?php echo esc_html(number_format($price, 0, '', '.')); ?></span>
          <span class="currency">đ</span>
        </div>
      </div>
    </div>

    <?php endwhile;
    wp_reset_postdata(); ?>
  </div>
  </div>

<?php
endif;