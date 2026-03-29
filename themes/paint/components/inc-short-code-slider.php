<?php
if (!empty($args['opt'])) :
  $opt_short_code_slider = paint_get_option($args['opt'], '');
  ?>
  <div class="element-banner">
    <?php echo do_shortcode( $opt_short_code_slider ); ?>
  </div>
<?php
endif;