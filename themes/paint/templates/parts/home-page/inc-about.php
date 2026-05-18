<?php

use ExtendSite\Admin\Fields\Pages\Home\AboutTab;

$data = paint_get_field_tab_data(AboutTab::class);

if ( empty( $data ) ) {
    return;
}
?>

<div class="element-about">
    <div class="container">
        <h2 class="element-about__heading element-page-heading mb-13 text-center">
            <?= esc_html($data['heading']); ?>
        </h2>
    </div>

    <div class="element-about__body">
        <div class="element-about__media">
            <?php
            if ( !empty( $data['image'] ) ) :
                echo wp_get_attachment_image( $data['image'], 'full' );
            endif;
            ?>
        </div>

        <div class="container">
            <div class="mw-1214 mh-inherit d-flex align-items-center">
                <div class="element-about__content">
                    <h3 class="sub-heading"><?= esc_html($data['sub_heading']); ?></h3>

                    <div class="description">
                        <?= wpautop(wp_kses_post( $data['description']) ); ?>
                    </div>

                    <?php if (!empty($data['button']['url']) && !empty($data['button']['text'])) : ?>
                        <a href="<?= esc_url($data['button']['url']); ?>"
                           class="hero-btn"
                        >
                            <span><?= esc_html($data['button']['text']); ?></span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
