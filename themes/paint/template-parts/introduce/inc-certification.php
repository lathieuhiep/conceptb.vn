<?php

use ExtendSite\Admin\Fields\Pages\About\CertificationTab;

$data = class_exists(CertificationTab::class)
    ? paint_get_field_tab_data(CertificationTab::class)
    : [];

$gallery_ids = array_filter(array_map('intval', (array)($data['images'] ?? [])));

if (empty($gallery_ids)) {
    return;
}
?>

<div class="element-about-gallery">
    <?php foreach ($gallery_ids as $item) : ?>
        <div class="item">
            <?php echo wp_get_attachment_image($item, 'medium_large'); ?>
        </div>
    <?php endforeach; ?>
</div>
