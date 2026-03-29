<?php
$opt_technology = paint_get_option('tpl_introduce_opt_technology_group');

if ($opt_technology) :
?>
<div class="element-technology d-flex flex-wrap">
  <?php foreach ($opt_technology as $item) : ?>
  <div class="item d-flex flex-column align-items-center justify-content-center" style="background-color: <?php echo esc_attr($item['color']); ?>">
    <?php if ( $item['image'] ) : ?>
    <figure class="item__thumbnail">
      <?php echo wp_get_attachment_image($item['image']['id']); ?>
    </figure>
    <?php endif; ?>

    <h3 class="item__title">
      <?php echo esc_html($item['title']); ?>
    </h3>

    <div class="item__desc">
      <?php echo wpautop($item['content']); ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php
endif;
