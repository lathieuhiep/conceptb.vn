<?php
get_header();

$paint_check_elementor = get_post_meta(get_the_ID(), '_elementor_edit_mode', true);

$paint_class_elementor = '';

if ($paint_check_elementor) :
  $paint_class_elementor = ' site-container-elementor';
endif;
?>

  <main class="site-container<?php echo esc_attr($paint_class_elementor); ?>">
    <?php
    if ($paint_check_elementor) :
      get_template_part('template-parts/page/content', 'page-elementor');
    else:
      get_template_part('template-parts/page/content', 'page');
    endif;
    ?>
  </main>

<?php

get_footer();