<?php
/*
 Template Name: FAQs Page
 */

get_header();

$opt_limit = paint_get_option('template_faq_opt_limit', 10);
$opt_order_by = paint_get_option('template_faq_opt_order_by', 'id');
$opt_order = paint_get_option('template_faq_opt_order', 'ASC');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Query
$args = array(
  'post_type' => 'paint_faq',
  'posts_per_page' => $opt_limit,
  'orderby' => $opt_order_by,
  'order' => $opt_order,
  'paged' => $paged,
  'ignore_sticky_posts' => 1,
);

$query = new WP_Query($args);
?>

  <div class="site-container faq-warp">
    <div class="container">
      <div class="top text-center">
        <h1 class="top__title mb-2">
          <?php echo get_the_title(); ?>
        </h1>

        <p class="top__heading text">
          <?php esc_html_e('Câu hỏi phổ biến về BColor', 'paint'); ?>
        </p>
      </div>

      <?php if ($query->have_posts()) : ?>
        <div class="accordion accordion-my-theme accordion-faq">
          <?php
          $i = 1;
          while ($query->have_posts()): $query->the_post();
            ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="post-<?php the_ID(); ?>">
                <button class="accordion-button<?php echo esc_attr($i !== 1 ? ' collapsed' : ''); ?>"
                        type="button" data-bs-toggle="collapse"
                        data-bs-target="#panels-post-<?php the_ID(); ?>" aria-expanded="true"
                        aria-controls="panels-post-<?php the_ID(); ?>">
                  <?php the_title(); ?>
                </button>
              </h2>

              <div id="panels-post-<?php the_ID(); ?>"
                   class="accordion-collapse collapse<?php echo esc_attr($i == 1 ? ' show' : ''); ?>"
                   aria-labelledby="post-<?php the_ID(); ?>">
                <div class="accordion-body">
                  <?php the_content(); ?>
                </div>
              </div>
            </div>
            <?php $i++; endwhile; ?>
        </div>
        <?php
        paint_paging_nav_query($query);

        wp_reset_postdata();
      endif;
      ?>
    </div>
  </div>

<?php
get_footer();
