<?php
$opt_image = paint_get_option('template_introduce_opt_community_image');
$opt_content = paint_get_option('template_introduce_opt_community_content');
?>

<div class="element-community">
  <figure class="element-community__thubmnail">
    <?php echo wp_get_attachment_image($opt_image['id'], 'full'); ?>

    <div class="desc">
      <?php echo wpautop($opt_content); ?>
    </div>
  </figure>
</div>
