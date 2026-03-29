<?php
if (!empty($args['opt'])) :
  $opt_banner = paint_get_option($args['opt'], '');
  $id_image = $opt_banner['id'];

  if ($id_image) :
    ?>
    <div class="element-banner">
      <?php echo wp_get_attachment_image($id_image, 'full', '', array(
              'class' => 'w-100'
      )); ?>
    </div>
  <?php
  endif;

endif;