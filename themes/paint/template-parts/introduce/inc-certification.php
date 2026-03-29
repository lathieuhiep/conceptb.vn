<?php
$opt_certification = paint_get_option('template_introduce_opt_certification');
$opt_image_size = paint_get_option('template_introduce_opt_image_size');
$opt_image_position = paint_get_option('template_introduce_opt_image_size_position');

if ($opt_certification) :
  $gallery_ids = explode(',', $opt_certification);
  ?>

  <div class="element-about-gallery">
    <?php foreach ($gallery_ids as $item) : ?>
      <div class="item <?php echo esc_attr($opt_image_position); ?>">
        <?php echo wp_get_attachment_image($item, $opt_image_size); ?>
      </div>
    <?php endforeach; ?>
  </div>

<?php
endif;