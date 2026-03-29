<?php

use ExtendSite\Admin\Fields\Pages\Home\GalleryTab;

$data = paint_get_field_tab_data(GalleryTab::class);

if (empty($data['group_gallery'])) {
    return;
}
?>
<div class="element-group-gallery">
    <div class="element-group-gallery__warp">
        <?php foreach ( $data['group_gallery'] as $group ) : ?>
            <div class="element-group-gallery__splide splide" data-direction="<?php echo esc_attr( $group['direction'] ); ?>">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach ($group['gallery'] as $image_id) : ?>
                            <li class="splide__slide d-flex align-items-center justify-content-center">
                                <?php echo wp_get_attachment_image($image_id, 'medium_large'); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
