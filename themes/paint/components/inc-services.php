<?php
$opt_services = paint_get_option('template_home_opt_about_services', '');

if ( $opt_services ) :
?>
<div class="element-services">
  <?php foreach ($opt_services as $item) : ?>
  <div class="item">
    <h3 class="item__title">
      <?php echo esc_html( $item['title'] ) ?>
    </h3>

    <div class="item__content">
      <?php echo esc_html( $item['describe'] ) ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php
endif;
