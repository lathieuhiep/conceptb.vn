<?php
// config slider
$data_config_slider = [
  'infinite' => true,
  'slidesToShow' => 3,
  'slidesToScroll' => 3,
  'arrows' => true,
  'autoplay' => false,
  'dots' => false,
  'responsive' => [
    [
      'breakpoint' => 991,
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

$list_cate = get_the_terms(get_the_ID(), 'category');

$term_ids = wp_get_post_terms(get_the_ID(), 'category', array('fields' => 'ids'));

if (!empty($term_ids)):
  $arg = array(
    'post_type' => 'post',
    'cat' => $term_ids,
    'post__not_in' => array(get_the_ID()),
    'posts_per_page' => 6,
  );

  $query = new WP_Query($arg);

  if ($query->have_posts()) :
    ?>
    <div class="site-single-post-related mt-5">
      <h3 class="title">
        <?php esc_html_e('Bài viết tương tự', 'paint'); ?>
      </h3>

      <div class="custom-slick-carousel" data-config-slick='<?php echo wp_json_encode($data_config_slider); ?>'>
        <?php
        while ($query->have_posts()) :
          $query->the_post();
          ?>
          <div class="item">
            <?php if (has_post_thumbnail()) : ?>
              <figure class="post-image mb-3">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('large'); ?>
                </a>
              </figure>
            <?php endif; ?>

            <h4 class="title-post">
              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php the_title(); ?>
              </a>
            </h4>

           <div class="action">
             <a href="<?php the_permalink(); ?>" class="view-post">
               <?php esc_html_e('Xem bài viết'); ?>
             </a>
           </div>
          </div>
        <?php
        endwhile;

        wp_reset_postdata();
        ?>
      </div>
    </div>
  <?php
  endif;
endif;