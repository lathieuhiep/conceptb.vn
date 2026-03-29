<?php
$show_loading = paint_get_option('general_opt_loading', 'off');

if ($show_loading) :
  $option_image_loading = paint_get_option('general_opt_image_loading', '');
  ?>
  <div id="site-loadding" class="d-flex align-items-center justify-content-center">
    <?php if (!empty($option_image_loading['url'])): ?>
      <img class="loading_img" src="<?php echo esc_url($option_image_loading['url']); ?>"
           alt="<?php esc_attr_e('loading...', 'paint') ?>">
    <?php else: ?>
      <img class="loading_img" src="<?php echo esc_url(get_theme_file_uri('/assets/images/loading.gif')); ?>"
           alt="<?php esc_attr_e('loading...', 'paint') ?>">
    <?php endif; ?>
  </div>
<?php endif; ?>