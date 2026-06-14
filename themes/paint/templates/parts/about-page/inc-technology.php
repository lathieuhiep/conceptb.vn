<?php

use ExtendSite\Admin\Fields\Pages\About\TechnologyTab;

$data = paint_get_field_tab_data(TechnologyTab::class);
$title = $data['title'] ?? '';
$background_image = (int)($data['background_image'] ?? 0);
$items = $data['items'] ?? [];

if ($title === '' && empty($background_image) && empty($items)) {
    return;
}

$background_style = '';

if (!empty($background_image)) {
    $background_url = wp_get_attachment_image_url($background_image, 'full');

    if (!empty($background_url)) {
        $background_style = sprintf(' style="background-image: linear-gradient(0deg, rgba(45, 50, 56, 0.78), rgba(45, 50, 56, 0.78)), url(%s);"', esc_url($background_url));
    }
}

$active_item = [];

foreach ($items as $item) {
    $item_title = trim((string)($item['title'] ?? ''));
    $description = trim((string)($item['description'] ?? ''));
    $image_id = (int)($item['image'] ?? 0);

    if ($item_title !== '' || $description !== '' || !empty($image_id)) {
        $active_item = $item;
        break;
    }
}
?>

<div class="about-technology"<?php echo $background_style; ?>>
    <div class="about-technology__inner">
        <?php if ($title !== '') : ?>
            <h2 class="about-technology__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <div class="about-technology__body">
            <article class="about-technology__panel" data-about-technology-panel>
                <h3 class="about-technology__panel-title" data-about-technology-title>
                    <?php echo esc_html($active_item['title'] ?? ''); ?>
                </h3>

                <p class="about-technology__panel-desc" data-about-technology-description>
                    <?php echo esc_html($active_item['description'] ?? ''); ?>
                </p>
            </article>

            <?php if (!empty($items)) : ?>
                <div class="about-technology__slider-wrap">
                    <div class="about-technology__slider swiper" data-about-technology-slider>
                        <div class="swiper-wrapper">
                            <?php foreach ($items as $item) : ?>
                                <?php
                                $image_id = (int)($item['image'] ?? 0);
                                $label = trim((string)($item['label'] ?? ''));
                                $item_title = trim((string)($item['title'] ?? ''));
                                $subtitle = trim((string)($item['subtitle'] ?? ''));
                                $description = trim((string)($item['description'] ?? ''));

                                if (empty($image_id) && $label === '' && $item_title === '' && $subtitle === '' && $description === '') {
                                    continue;
                                }
                                ?>

                                <article
                                    class="about-technology-card swiper-slide"
                                    data-about-technology-slide
                                    data-title="<?php echo esc_attr($item_title); ?>"
                                    data-description="<?php echo esc_attr($description); ?>"
                                >
                                    <figure class="about-technology-card__image">
                                        <?php if (!empty($image_id)) : ?>
                                            <?php
                                            echo wp_get_attachment_image(
                                                $image_id,
                                                'large',
                                                false,
                                                [
                                                    'class' => 'about-technology-card__img',
                                                    'loading' => 'lazy',
                                                ]
                                            );
                                            ?>
                                        <?php else : ?>
                                            <span class="about-technology-card__placeholder"></span>
                                        <?php endif; ?>
                                    </figure>

                                    <div class="about-technology-card__content">
                                        <?php if ($label !== '') : ?>
                                            <span class="about-technology-card__label"><?php echo esc_html($label); ?></span>
                                        <?php endif; ?>

                                        <?php if ($item_title !== '') : ?>
                                            <h3 class="about-technology-card__title"><?php echo esc_html($item_title); ?></h3>
                                        <?php endif; ?>

                                        <?php if ($subtitle !== '') : ?>
                                            <p class="about-technology-card__subtitle"><?php echo esc_html($subtitle); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="about-technology__progress" aria-hidden="true">
                        <span class="about-technology__progress-bar" data-about-technology-progress></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
