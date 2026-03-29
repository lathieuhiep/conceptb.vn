<?php
$opt_cat = paint_get_option('template_home_opt_product_cat', '');
$opt_limit = paint_get_option('template_home_opt_product_limit', 10);
$opt_order_by = paint_get_option('template_home_opt_product_order_by', 'id');
$opt_order = paint_get_option('template_home_opt_product_order', 'DESC');

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
  'post_type' => 'paint_product',
  'posts_per_page' => $opt_limit,
  'orderby' => $opt_order_by,
  'order' => $opt_order,
  'tax_query' => $tax_query
);

$query = new WP_Query($args);

if ($query->have_posts()) :
  ?>

  <div class="element-products">
    <div class="row row-cols-2 row-cols-md-4">
      <?php
      while ($query->have_posts()):
        $query->the_post();

        $image_hover = get_post_meta(get_the_ID(), 'paint_cmb_product_image_feature_hover_id', true);
        ?>
        <div class="col item">
          <div class="thumbnail">
            <a class="link-image" href="<?php the_permalink(); ?>">
              <?php
              the_post_thumbnail('medium_large', ['class' => 'img-feature']);
              echo wp_get_attachment_image($image_hover, 'large', '', array("class" => "img-feature-hover"));
              ?>
            </a>
          </div>

          <h2 class="title">
            <a href="<?php the_permalink(); ?>">
              <?php the_title() ?>
            </a>
          </h2>
        </div>
      <?php endwhile;
      wp_reset_postdata(); ?>
    </div>

    <div class="link-all">
      <a href="<?php echo esc_url( get_post_type_archive_link( 'paint_product' ) ); ?>">
        <?php esc_html_e('Xem thêm', 'paint'); ?>
      </a>
    </div>
  </div>

<?php
endif;