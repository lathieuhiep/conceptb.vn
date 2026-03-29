<?php
if (!empty($args['opt'])) :
  $opt_heading = paint_get_option($args['opt'], '');
  ?>
  <h2 class="heading text-<?php echo esc_attr($opt_heading['align']); ?>">
    <?php echo esc_html($opt_heading['title']); ?>
  </h2>
<?php
endif;