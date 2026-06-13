<?php

use ExtendSite\Admin\Fields\Pages\About\ServicesTab;

$data = paint_get_field_tab_data(ServicesTab::class);
$title = $data['title'] ?? '';
$items = $data['items'] ?? [];

if ($title === '' && empty($items)) {
    return;
}
?>

<div class="about-services">
    <div class="about-container">
        <?php if ($title !== '') : ?>
            <h2 class="about-services__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($items)) : ?>
            <div class="about-services__list">
                <?php foreach ($items as $index => $item) : ?>
                    <?php
                    $image_id = (int)($item['image'] ?? 0);
                    $item_title = trim((string)($item['title'] ?? ''));
                    $description = trim((string)($item['description'] ?? ''));

                    if (empty($image_id) && $item_title === '' && $description === '') {
                        continue;
                    }
                    ?>

                    <article class="about-service-item">
                        <figure class="about-service-item__image">
                            <?php if (!empty($image_id)) : ?>
                                <?php
                                echo wp_get_attachment_image(
                                    $image_id,
                                    'large',
                                    false,
                                    [
                                        'class' => 'about-service-item__img',
                                        'loading' => 'lazy',
                                    ]
                                );
                                ?>
                            <?php else : ?>
                                <span class="about-service-item__placeholder"></span>
                            <?php endif; ?>
                        </figure>

                        <div class="about-service-item__content">
                            <div class="about-service-item__head">
                                <span class="about-service-item__number"><?php echo esc_html($index + 1); ?></span>

                                <?php if ($item_title !== '') : ?>
                                    <h3 class="about-service-item__title"><?php echo esc_html($item_title); ?></h3>
                                <?php endif; ?>
                            </div>

                            <span class="about-service-item__line" aria-hidden="true"></span>

                            <?php if ($description !== '') : ?>
                                <p class="about-service-item__desc"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
