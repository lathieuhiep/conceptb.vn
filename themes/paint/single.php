<?php
get_header();

$sidebar = paint_get_option('paint_opt_single_sidebar', 'right');
$class_col_content = paint_col_use_sidebar($sidebar, 'paint-sidebar-main');
?>

<div class="site-container site-single">
  <div class="container">
    <div class="row">
      <div class="<?php echo esc_attr($class_col_content); ?>">
        <?php
        if (have_posts()) : while (have_posts()) : the_post();

          get_template_part('template-parts/post/content', 'single');

        endwhile;
        endif;
        ?>
      </div>

      <?php
      if ($sidebar !== 'hide') :
        get_sidebar();
      endif;
      ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>

