<?php

use ExtendSite\Admin\Fields\Pages\Home\VolunteerTab;

$data = paint_get_field_tab_data(VolunteerTab::class);

if ( !empty($data['gallery']) ) :
    ?>
    <section class="element-volunteer">
        <div class="element-volunteer__top mb-4">
            <div class="container">
                <?php if (!empty($data['title'])) : ?>
                    <h2 class="element-page-heading element-page-heading mb-lg-13 text-center">
                        <?php echo esc_html($data['title']); ?>
                    </h2>
                <?php endif; ?>

                <?php if (!empty($data['description'])) : ?>
                    <div class="element-volunteer__desc text-center">
                        <?php echo wpautop($data['description']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="element-volunteer__gallery">
            <div class="swiper swiper-volunteer">
                <div class="swiper-wrapper">
                    <?php foreach ($data['gallery'] as $image) : ?>
                    <div class="swiper-slide">
                        <?php echo wp_get_attachment_image((int)$image, 'large'); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php
endif;