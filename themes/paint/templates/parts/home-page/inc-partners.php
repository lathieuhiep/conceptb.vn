<?php

use ExtendSite\Admin\Fields\Pages\Home\PartnerTab;

$data = paint_get_field_tab_data(PartnerTab::class);

if (empty($data['gallery'])) {
    return;
}
?>
<div class="element-partner py-12">
    <div class="element-partner__warp">
        <div class="element-partner__splide splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach ($data['gallery'] as $image_id) : ?>
                        <li class="splide__slide d-flex align-items-center justify-content-center"><?php echo wp_get_attachment_image($image_id, 'medium'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
