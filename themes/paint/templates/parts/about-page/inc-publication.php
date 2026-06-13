<?php

use ExtendSite\Admin\Fields\Pages\About\PublicationTab;

$data = paint_get_field_tab_data(PublicationTab::class);
$title = $data['title'] ?? '';
$subtitle = $data['subtitle'] ?? '';
$background_image = $data['background_image'] ?? 0;
$items = $data['items'] ?? [];

if ($title === '' && $subtitle === '' && empty($background_image) && empty($items)) {
    return;
}

$background_style = '';

if (!empty($background_image)) {
    $background_url = wp_get_attachment_image_url($background_image, 'full');

    if (!empty($background_url)) {
        $background_style = sprintf(' style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(%s);"', esc_url($background_url));
    }
}
?>

<div class="about-publication">
    <div class="about-container">
        <div class="about-publication__header">
            <?php if ($title !== '') : ?>
                <h2 class="about-publication__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($subtitle !== '') : ?>
                <p class="about-publication__subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>

        <div class="about-publication__showcase"<?php echo $background_style; ?>>
            <div class="about-publication__list">
                <?php foreach ($items as $index => $item) : ?>
                    <?php
                    $cover_image = (int)($item['cover_image'] ?? 0);
                    $item_title = trim((string)($item['title'] ?? ''));
                    $shortcode = trim((string)($item['shortcode'] ?? ''));
                    $template_id = 'about-publication-template-' . absint($index);

                    if (empty($cover_image) && $item_title === '' && $shortcode === '') {
                        continue;
                    }
                    ?>

                    <div class="about-publication__item">
                        <?php if ($shortcode !== '') : ?>
                            <button class="about-publication__trigger" type="button" data-bs-toggle="modal" data-bs-target="#about-publication-modal" data-publication-template="<?php echo esc_attr($template_id); ?>">
                                <?php if (!empty($cover_image)) : ?>
                                    <?php
                                    echo wp_get_attachment_image(
                                        $cover_image,
                                        'large',
                                        false,
                                        [
                                            'class' => 'about-publication__cover',
                                            'loading' => 'lazy',
                                        ]
                                    );
                                    ?>
                                <?php else : ?>
                                    <span class="about-publication__placeholder">
                                        <?php echo esc_html($item_title); ?>
                                    </span>
                                <?php endif; ?>
                            </button>
                        <?php else : ?>
                            <?php if (!empty($cover_image)) : ?>
                                <?php
                                echo wp_get_attachment_image(
                                    $cover_image,
                                    'large',
                                    false,
                                    [
                                        'class' => 'about-publication__cover',
                                        'loading' => 'lazy',
                                    ]
                                );
                                ?>
                            <?php else : ?>
                                <div class="about-publication__placeholder">
                                    <?php echo esc_html($item_title); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($shortcode !== '') : ?>
                        <template id="<?php echo esc_attr($template_id); ?>">
                            <?php echo do_shortcode(wp_kses_post($shortcode)); ?>
                        </template>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="modal fade about-publication-modal" id="about-publication-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <button class="about-publication-modal__close" type="button" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Đóng', 'paint'); ?>">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>

                <div class="modal-body" data-publication-modal-body></div>
            </div>
        </div>
    </div>
</div>
