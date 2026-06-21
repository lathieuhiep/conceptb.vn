<?php

use ExtendSite\Admin\Fields\Pages\About\CertificationTab;

$data = paint_get_field_tab_data(CertificationTab::class);
$title = $data['title'] ?? '';
$images = array_filter((array)($data['images'] ?? []), static function ($item): bool {
    return is_array($item) && !empty($item['image_id']);
});

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
                <div class="about-certification__slider" data-about-certification-slider>
                    <div class="about-certification__gallery swiper" data-about-certification-swiper>
                        <div class="swiper-wrapper">
                            <?php foreach ($images as $item) : ?>
                                <?php
                                $image_id = (int)($item['image_id'] ?? 0);
                                $image_title = trim((string)($item['title'] ?? ''));
                                ?>

                                <div class="about-certification__slide swiper-slide">
                                    <figure class="about-certification__image">
                                        <div class="about-certification__media">
                                            <?php if (!empty($image_id)) : ?>
                                                <?php $full_image_url = wp_get_attachment_image_url($image_id, 'full'); ?>

                                                <a
                                                    class="about-certification__link"
                                                    href="<?php echo esc_url($full_image_url); ?>"
                                                    aria-label="<?php echo esc_attr($image_title !== '' ? $image_title : __('Xem ảnh chứng nhận', 'paint')); ?>"
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
                                        </div>

                                        <?php if ($image_title !== '') : ?>
                                            <figcaption class="about-certification__caption"><?php echo esc_html($image_title); ?></figcaption>
                                        <?php endif; ?>
                                    </figure>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button class="about-certification__nav about-certification__nav--prev" type="button" aria-label="<?php esc_attr_e('Previous', 'paint'); ?>">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </button>
                    <button class="about-certification__nav about-certification__nav--next" type="button" aria-label="<?php esc_attr_e('Next', 'paint'); ?>">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
