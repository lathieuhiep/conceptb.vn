<?php

use ExtendSite\Admin\Fields\Pages\About\HeroTab;

$data = paint_get_field_tab_data(HeroTab::class);
$image_id = $data['image'] ?? 0;
?>

<div class="about-hero">
    <?php if (!empty($image_id)) : ?>
        <?php
        echo wp_get_attachment_image(
            $image_id,
            'full',
            false,
            [
                'class' => 'about-hero__image',
                'loading' => 'eager',
                'fetchpriority' => 'high',
            ]
        );
        ?>
    <?php else : ?>
        <div class="about-hero__placeholder"></div>
    <?php endif; ?>
</div>
