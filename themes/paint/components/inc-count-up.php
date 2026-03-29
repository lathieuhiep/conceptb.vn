<?php
$opt_result_count_bottom = paint_get_option('template_home_opt_result_count_bottom', '');

if ($opt_result_count_bottom) :
?>

<div class="element-count-up">
  <?php foreach ($opt_result_count_bottom as $item) : ?>
    <div class="item">
        <div class="item__icon">
          <?php echo wp_get_attachment_image($item['image']['id'], 'full'); ?>
        </div>

        <div class="item__content">
          <div class="count-box">
            <span class="number-counter" data-number="<?php echo esc_attr($item['count']); ?>">0</span>

            <?php if ($item['show_icon']) : ?>
              <span class="symbol">+</span>
            <?php endif; ?>
          </div>

          <p class="text">
            <?php echo esc_html($item['title']); ?>
          </p>
        </div>
      </div>
  <?php endforeach; ?>
</div>

<?php endif; ?>