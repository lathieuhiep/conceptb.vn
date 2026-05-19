<?php

use ExtendSite\Admin\Fields\Pages\Home\ContactTab;

$data = paint_get_field_tab_data(ContactTab::class);

if ( empty($data) ) {
    return;
}
?>
<div class="element-contact">
    <div class="container">
        <h2 class="element-contact__heading element-page-heading text-center">
            <?= esc_html($data['heading']); ?>
        </h2>
        <?php if ( !empty( $data['form_id'] ) ) : ?>
            <div class="element-contact__form">
                <?php echo do_shortcode( '[contact-form-7 id="' . $data['form_id'] . '" ]' ); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
