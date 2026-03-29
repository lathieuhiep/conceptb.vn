<?php
$opt_our_maxim = paint_get_option('tpl_introduce_opt_our_maxim_group');
if ($opt_our_maxim) :
?>

<div class="element-our-maxim">
  <div class="d-flex justify-content-center flex-wrap">
    <?php foreach ($opt_our_maxim as $item) : ?>
      <div class="item text-center">
        <h4 class="item__title">
          <?php echo esc_html($item['title']); ?>
        </h4>

        <div class="item__desc">
          <?php echo wpautop($item['content']); ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
endif;