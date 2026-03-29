<?php
get_header();

$search_query = get_search_query();
$s = $_GET['s'];
$cat = !empty($_GET['cat']) ? (int) $_GET['cat'] : '';
$opt_project_limit = paint_get_option('template_project_opt_limit', 12);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$tax_query = array();
if (!empty($cat)) {
  $tax_query = array(
    array(
      'taxonomy' => 'paint_project_cat',
      'field' => 'term_id',
      'terms' => $cat
    ),
  );
}

$args = array(
  'post_type' => 'paint_project',
  'ignore_sticky_posts' => 1,
  's' => $s,
  'posts_per_page' => $opt_project_limit,
  'paged' => $paged,
  'tax_query' => $tax_query,
);

$query = new WP_Query($args);
?>

<div class="site-container site-result-project">
  <div class="container">
    <?php
    get_template_part('template-parts/project/inc', 'search-cat');

    if ($search_query) :
    ?>
      <header class="heading">
        <h1 class="page-title">
          <?php _e('Kết quả tìm kiếm cho', 'paint'); ?>: "<?php echo esc_html($search_query); ?>"
        </h1>
      </header>
    <?php
    endif;

    if ($query->have_posts()) :
    ?>
      <div class="project-grid project-layout">
        <?php
        while ($query->have_posts()) : $query->the_post();

          get_template_part('template-parts/project/inc', 'item');

        endwhile;
        wp_reset_postdata();
        ?>
      </div>
    <?php
      paint_paging_nav_query($query);
    else:
    ?>
    <p class="text-note">
      <?php esc_html_e('Không có kết quả phù hợp', 'paint'); ?>
    </p>
    <?php endif; ?>
  </div>
</div>

<?php
get_footer();
