<?php
use ExtendSite\Admin\Fields\Pages\Construction\RecommendationTab;

$data = paint_get_field_tab_data(RecommendationTab::class);
$background_image_id = $data['background_image'] ?? 0;
$process_content = $data['process_content'] ?? '';
$table_content = $data['table_content'] ?? '';
$button_text = $data['button_text'] ?? '';
$button_link = $data['button_link'] ?? '';
$background_image_url = $background_image_id ? wp_get_attachment_image_url($background_image_id, 'full') : '';

if ($process_content === '' && $table_content === '' && ($button_text === '' || $button_link === '')) {
  return;
}
?>

<section class="construction-recommendation"<?php if ($background_image_url) : ?> style="background-image: url('<?php echo esc_url($background_image_url); ?>');"<?php endif; ?>>
  <div class="construction-container">
    <?php if ($process_content !== '') : ?>
      <div class="construction-recommendation__content construction-recommendation__content--process">
        <?php echo wp_kses_post(wpautop($process_content)); ?>
      </div>
    <?php endif; ?>

    <?php if ($table_content !== '') : ?>
      <div class="construction-recommendation__content construction-recommendation__content--table">
        <?php echo wp_kses_post(wpautop($table_content)); ?>
      </div>
    <?php endif; ?>

    <?php if ($button_text !== '' && $button_link !== '') : ?>
      <div class="construction-recommendation__action">
        <a class="construction-recommendation__button" href="<?php echo esc_url($button_link); ?>">
          <?php echo esc_html($button_text); ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>
