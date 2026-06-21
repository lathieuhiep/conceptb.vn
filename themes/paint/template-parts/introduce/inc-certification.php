<?php

use ExtendSite\Admin\Fields\Pages\About\CertificationTab;

$data = class_exists(CertificationTab::class)
    ? paint_get_field_tab_data(CertificationTab::class)
    : [];

$gallery = array_filter((array)($data['images'] ?? []), static function ($item): bool {
    return is_array($item) && !empty($item['image_id']);
});

if (empty($gallery)) {
    return;
}
?>

<div class="element-about-gallery">
    <?php foreach ($gallery as $item) : ?>
        <?php
        $image_id = (int)($item['image_id'] ?? 0);
        $image_title = trim((string)($item['title'] ?? ''));
        ?>

        <figure class="item">
            <?php echo wp_get_attachment_image($image_id, 'medium_large'); ?>

            <?php if ($image_title !== '') : ?>
                <figcaption class="item-title"><?php echo esc_html($image_title); ?></figcaption>
            <?php endif; ?>
        </figure>
    <?php endforeach; ?>
</div>
