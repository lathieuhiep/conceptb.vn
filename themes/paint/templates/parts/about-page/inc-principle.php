<?php

use ExtendSite\Admin\Fields\Pages\About\PrincipleTab;

$data = paint_get_field_tab_data(PrincipleTab::class);
$title = $data['title'] ?? '';
$description = $data['description'] ?? '';
$images = $data['images'] ?? [];

if ($title === '' && $description === '' && empty($images)) {
    return;
}
?>

<section class="about-principle">
    <div class="about-container">
        <div class="about-principle__inner">
            <?php if ($title !== '') : ?>
                <h2 class="about-principle__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($description !== '') : ?>
                <p class="about-principle__desc"><?php echo esc_html($description); ?></p>
            <?php endif; ?>

            <?php if (!empty($images)) : ?>
                <div class="about-principle__gallery">
                    <?php foreach ($images as $image_id) : ?>
                        <?php
                        $image_id = (int)$image_id;
                        ?>

                        <figure class="about-principle__image">
                            <?php if (!empty($image_id)) : ?>
                                <?php
                                echo wp_get_attachment_image(
                                    $image_id,
                                    'large',
                                    false,
                                    [
                                        'class' => 'about-principle__img',
                                        'loading' => 'lazy',
                                    ]
                                );
                                ?>
                            <?php else : ?>
                                <span class="about-principle__placeholder"></span>
                            <?php endif; ?>
                        </figure>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
