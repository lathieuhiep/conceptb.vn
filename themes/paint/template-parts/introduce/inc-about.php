<?php
$opt_title = paint_get_option('template_introduce_opt_title', '');
$opt_image = paint_get_option('template_introduce_opt_image', '');
$opt_desc = paint_get_option('template_introduce_opt_desc', '');
?>

<div class="element-about">
  <h2 class="title text-center">
    <?php echo esc_html($opt_title); ?>
  </h2>

  <div class="row row-cols-1 row-cols-md-2">
    <div class="col">
      <div class="box-image">
        <?php
        if ($opt_image) :
          echo wp_get_attachment_image($opt_image['id'], 'full');
        endif;
        ?>
      </div>
    </div>

    <div class="col">
        <div class="desc">
	        <?php echo wpautop($opt_desc); ?>
        </div>
    </div>
  </div>
</div>
