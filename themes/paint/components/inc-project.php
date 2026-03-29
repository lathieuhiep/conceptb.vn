<?php
$opt_desc = paint_get_option('template_home_opt_project_content', '');
$opt_limit = paint_get_option('template_home_opt_project_limit', 10);
$opt_order_by = paint_get_option('template_home_opt_project_order_by', 'id');
$opt_order = paint_get_option('template_home_opt_project_order', 'DESC');

// config slider
$data_config_slider = [
  'infinite' => true,
  'slidesToShow' => 3,
  'arrows' => true,
  'autoplay' => false,
  'dots' => false,
  'responsive' => [
    [
      'breakpoint' => 1023,
      'settings' => [
        'slidesToShow' => 3,
        'slidesToScroll' => 3,
      ]
    ],
    [
      'breakpoint' => 767,
      'settings' => [
        'slidesToShow' => 2,
        'slidesToScroll' => 2,
      ]
    ],
    [
      'breakpoint' => 575,
      'settings' => [
        'slidesToShow' => 1,
        'slidesToScroll' => 1,
      ]
    ],
  ],
];

// Query
$args = array(
  'post_type' => 'paint_project',
  'posts_per_page' => $opt_limit,
  'orderby' => $opt_order_by,
  'order' => $opt_order,
  'ignore_sticky_posts' => 1,
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>

<div class="element-project">
  <?php if ( $opt_desc ) : ?>
  <div class="desc">
    <?php echo wpautop( $opt_desc ); ?>
  </div>
  <?php endif; ?>

  <div class="project-content custom-slick-carousel" data-config-slick='<?php echo wp_json_encode($data_config_slider); ?>'>
    <?php while ($query->have_posts()): $query->the_post(); ?>
      <div class="item">
        <div class="thumbnail">
          <a class="link-image" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('medium_large'); ?>
          </a>

          <h2 class="title">
            <a href="<?php the_permalink(); ?>">
              <?php the_title() ?>
            </a>
          </h2>
        </div>
      </div>
    <?php
    endwhile;
    wp_reset_postdata();
    ?>
  </div>

  <div class="link-all">
    <a href="<?php echo esc_url( get_post_type_archive_link( 'paint_project' ) ); ?>">
      <?php esc_html_e('Xem thêm', 'paint'); ?>
    </a>
  </div>
</div>

<?php
endif;