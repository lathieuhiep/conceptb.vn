<?php

use ExtendSite\Admin\Fields\Pages\About\CertificationTab;

$data = paint_get_field_tab_data(CertificationTab::class);
$title = $data['title'] ?? '';
$images = array_filter(array_map('intval', (array)($data['images'] ?? [])));

if ($title === '' && empty($images)) {
    return;
}
?>

<section class="about-certification">
    <div class="about-container">
        <div class="about-certification__inner">
            <?php if ($title !== '') : ?>
                <h2 class="about-certification__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if (!empty($images)) : ?>
                <div class="about-certification__gallery">
                    <?php foreach ($images as $image_id) : ?>
                        <?php $image_id = (int)$image_id; ?>

                        <figure class="about-certification__image">
                            <?php if (!empty($image_id)) : ?>
                                <?php $full_image_url = wp_get_attachment_image_url($image_id, 'full'); ?>

                                <a
                                    class="about-certification__link"
                                    href="<?php echo esc_url($full_image_url); ?>"
                                    aria-label="<?php echo esc_attr__('Xem ảnh chứng nhận', 'paint'); ?>"
                                >
                                <?php
                                echo wp_get_attachment_image(
                                    $image_id,
                                    'medium_large',
                                    false,
                                    [
                                        'class' => 'about-certification__img',
                                        'loading' => 'lazy',
                                    ]
                                );
                                ?>
                                </a>
                            <?php else : ?>
                                <span class="about-certification__placeholder"></span>
                            <?php endif; ?>
                        </figure>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
