<?php

use ExtendSite\Admin\Fields\Pages\Home\HeroTab;

$data = paint_get_field_tab_data(HeroTab::class);
?>
<div class="element-hero-banner-main">
    <div class="hero-image">
        <?php
        if ( !empty( $data['image_banner'] ) ) :
            echo wp_get_attachment_image( $data['image_banner'], 'full', false, [ 'class' => 'w-100 h-100 object-fit-cover' ] );
        endif;
        ?>
    </div>

    <div class="hero-content">
        <div class="container h-100 position-relative d-flex flex-column justify-content-between">
            <div class="hero-content__top">
                <?php
                // Caption
                if (!empty($data['caption'])) {
                    printf(
                            '<div class="hero-caption">%s</div>',
                            esc_html($data['caption'])
                    );
                }

                // Headline
                if (!empty($data['headline'])) {
                    printf(
                            '<%1$s class="hero-headline">%2$s</%1$s>',
                            esc_attr($data['tag']),
                            esc_html($data['headline'])
                    );
                }
                ?>

                <?php if (!empty($data['button']['text']) && !empty($data['button']['link'])) : ?>
                    <div class="hero-action">
                        <a class="hero-btn" href="<?php echo esc_url($data['button']['link']); ?>">
                            <span><?php echo esc_html($data['button']['text']); ?></span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="hero-content__footer d-flex align-items-center justify-content-center">
                <div class="hero-scroll-hint text-center">
                    <div class="mouse-icon">
                        <div class="wheel"></div>
                    </div>

                    <div class="arrow-down">
                        <i class="fa-solid fa-angles-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

