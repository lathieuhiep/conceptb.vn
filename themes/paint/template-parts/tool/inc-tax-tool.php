<?php
if (have_posts()) :
?>

  <div class="tools-warp">
    <h1 class="heading text-center">
      <?php
      if ( is_post_type_archive('paint_tool') ) {
        esc_html_e('Dụng cụ thi công', 'paint');
      } else {
        $term = get_queried_object();

        echo esc_html($term->name);
      }
       ?>
    </h1>

    <div class="tool-list-grid tool-grid-tax">
      <?php
      while (have_posts()) :
        the_post();

        get_template_part('template-parts/tool/inc', 'item');

      endwhile;
      wp_reset_postdata();
      ?>
    </div>

    <?php paint_pagination(); ?>
  </div>

<?php
endif;