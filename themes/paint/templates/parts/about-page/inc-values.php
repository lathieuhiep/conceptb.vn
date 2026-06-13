<?php

use ExtendSite\Admin\Fields\Pages\About\ValuesTab;

$data = paint_get_field_tab_data(ValuesTab::class);
$items = $data['items'] ?? [];

if (empty($items)) {
    return;
}
?>

<div class="about-values">
    <div class="about-container">
        <div class="about-values__inner">
            <?php foreach ($items as $item) : ?>
                <?php
                $icon_image = (int)($item['icon_image'] ?? 0);
                $title = trim((string)($item['title'] ?? ''));
                $description = trim((string)($item['description'] ?? ''));

                if ($title === '' && $description === '') {
                    continue;
                }
                ?>

                <article class="about-value-card">
                    <?php if (!empty($icon_image)) : ?>
                        <span class="about-value-card__icon" aria-hidden="true">
                        <?php
                        echo wp_get_attachment_image(
                            $icon_image,
                            'thumbnail',
                            false,
                            [
                                'class' => 'about-value-card__icon-image',
                                'loading' => 'lazy',
                            ]
                        );
                        ?>
                    </span>
                    <?php endif; ?>

                    <div class="about-value-card__content">
                        <?php if ($title !== '') : ?>
                            <h2 class="about-value-card__title"><?php echo esc_html($title); ?></h2>
                        <?php endif; ?>

                        <?php if ($description !== '') : ?>
                            <p class="about-value-card__desc"><?php echo esc_html($description); ?></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</div>
