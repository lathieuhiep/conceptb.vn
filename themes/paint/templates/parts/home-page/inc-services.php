<?php

use ExtendSite\Admin\Fields\Pages\Home\ServicesTab;

$data = paint_get_field_tab_data(ServicesTab::class);

if ( empty($data) ) {
    return;
}
?>

<div class="element-services">
    <div class="container">
        <h2 class="element-services__heading element-page-heading mb-lg-19 text-center">
            <?= esc_html($data['heading']); ?>
        </h2>

        <?php if ( !empty( $data['items'] ) ) : ?>
            <div class="element-services__list mw-1214 d-flex flex-column gap-6">
                <?php foreach ( $data['items'] as $item ) : ?>
                    <div class="item">
                       <div class="item__icon">
                           <div class="icon-box d-flex align-items-center justify-content-center">
                               <?php
                               if ( !empty( $item['icon'] ) ) :
                                   echo wp_get_attachment_image( $item['icon'] );
                               endif;
                               ?>
                           </div>
                       </div>

                        <div class="item__body">
                            <h3 class="item__title">
                                <?= esc_html( $item['title'] ); ?>
                            </h3>

                            <div class="item__desc">
                                <?= wpautop( wp_kses_post( $item['desc'] ) ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>