<?php

use ExtendSite\Admin\Fields\Pages\About\IntroTab;

$data = paint_get_field_tab_data(IntroTab::class);
$title = $data['title'] ?? '';
$subtitle = $data['subtitle'] ?? '';
$description = $data['description'] ?? '';
$image_id = $data['image'] ?? 0;

if ($title === '' && $subtitle === '' && $description === '' && empty($image_id)) {
    return;
}
?>

<div class="about-intro">
    <div class="about-container">
        <div class="about-intro__header">
            <?php if ($title !== '') : ?>
                <h2 class="about-intro__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($subtitle !== '') : ?>
                <p class="about-intro__subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>

            <span class="about-intro__line" aria-hidden="true"></span>
        </div>

        <div class="about-intro__body">
            <?php if ($description !== '') : ?>
                <div class="about-intro__desc">
                    <?php echo wp_kses_post(wpautop($description)); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($image_id)) : ?>
                <figure class="about-intro__image">
                    <?php
                    echo wp_get_attachment_image(
                        $image_id,
                        'full',
                        false,
                        [
                            'class' => 'about-intro__img',
                            'loading' => 'lazy',
                        ]
                    );
                    ?>
                </figure>
            <?php endif; ?>
        </div>
    </div>
</div>
