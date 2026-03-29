<?php
$opt_cat = paint_get_option('template_home_opt_discover_cat', '');
$opt_limit = paint_get_option('template_home_opt_discover_limit', 10);
$opt_order_by = paint_get_option('template_home_opt_discover_order_by', 'id');
$opt_order = paint_get_option('template_home_opt_discover_order', 'DESC');

$tax_query = array();
if ($opt_cat) {
  $tax_query = array(
    array(
      'taxonomy' => 'paint_product_cat',
      'field' => 'term_id',
      'terms' => $opt_cat
    ),
  );
}

$args = array(
  'post_type' => 'paint_discover',
  'posts_per_page' => $opt_limit,
  'orderby' => $opt_order_by,
  'order' => $opt_order,
  'tax_query' => $tax_query
);

$query = new WP_Query($args);

if ($query->have_posts()) :
  ?>
  <div class="element-discover">
    <div class="element-discover__grid">
      <?php
      while ($query->have_posts()):
        $query->the_post();
      ?>
        <div class="item">
          <figure class="thumbnail-image">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium_large'); ?>
            </a>
          </figure>

          <h2 class="title-item view-detail">
            <a href="<?php the_permalink(); ?>">
              <?php the_title() ?>
            </a>
          </h2>

          <?php if (has_term('', 'paint_discover_cat')) : ?>
            <div class="meta">
              <?php the_terms(get_the_ID(), 'paint_discover_cat', '', ', '); ?>
            </div>
          <?php endif; ?>
        </div>
      <?php
      endwhile;
      wp_reset_postdata();
      ?>
    </div>

    <div class="link-all">
      <a href="<?php echo esc_url(get_post_type_archive_link('paint_discover')); ?>">
        <?php esc_html_e('Xem thêm', 'paint'); ?>
      </a>
    </div>
  </div>
<?php
endif;
