<?php
use ExtendSite\Admin\Fields\Pages\Construction\ContactTab;

$data = paint_get_field_tab_data(ContactTab::class);

if (empty($data) || (empty($data['heading']) && empty($data['form_id']))) {
  return;
}
?>

<div class="element-contact construction-contact">
  <div class="container">
    <?php if (!empty($data['heading'])) : ?>
      <h2 class="element-contact__heading construction-contact__heading text-center">
        <?php echo esc_html($data['heading']); ?>
      </h2>
    <?php endif; ?>

    <?php if (!empty($data['form_id'])) : ?>
      <div class="element-contact__form">
        <?php echo do_shortcode('[contact-form-7 id="' . (int) $data['form_id'] . '" ]'); ?>
      </div>
    <?php endif; ?>
  </div>
</div>
