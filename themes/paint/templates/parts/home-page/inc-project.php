<?php

use ExtendSite\Admin\Fields\Pages\Home\ProjectTab;

$data = paint_get_field_tab_data(ProjectTab::class);

if (!empty($data['items'])) :
    ?>
    <section class="element-project">
        <div class="element-project__top">
            <div class="container">
                <?php if (!empty($data['title'])) : ?>
                    <h2 class="element-page-heading element-page-heading mb-lg-18 text-center">
                        <?php echo esc_html($data['title']); ?>
                    </h2>
                <?php endif; ?>

                <?php if (!empty($data['description'])) : ?>
                    <div class="element-project__desc text-center typing">
                        <?php echo wpautop($data['description']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="element-project__slider-wrap">
            <div class="swiper element-project__swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($data['items'] as $index => $item) : ?>
                        <div class="swiper-slide">
                            <div class="project-card">
                                <?php if (!empty($item['image'])) : ?>
                                    <div class="project-card__media">
                                        <img
                                            src="<?php echo esc_url($item['image']); ?>"
                                            alt="<?php echo esc_attr($item['name']); ?>"
                                            loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                                        >
                                    </div>
                                <?php endif; ?>

                                <div class="project-card__info">
                                    <div class="project-card__info-left">
                                        <?php if (!empty($item['name'])) : ?>
                                            <h3 class="project-card__name">
                                                <?php echo esc_html($item['name']); ?>
                                            </h3>
                                        <?php endif; ?>

                                        <?php if (!empty($item['subtitle'])) : ?>
                                            <p class="project-card__subtitle">
                                                <?php echo esc_html($item['subtitle']); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($item['scale'])) : ?>
                                        <div class="project-card__info-right d-flex flex-column gap-1 align-items-xs-end">
                                            <span class="project-card__scale-label">
                                                <?php esc_html_e('Quy mô dự án', 'extend-site'); ?>
                                            </span>
                                            <span class="project-card__scale-value">
                                                <?php echo esc_html($item['scale']); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="project-card__overlay"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($data['button']['link'])) : ?>
            <div class="element-project__footer text-center ps-3 pe-3">
                <a href="<?php echo esc_url($data['button']['link']); ?>" class="btn-outline">
                    <?php echo esc_html($data['button']['text'] ?? __('Xem thêm công trình', 'extend-site')); ?>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        <?php endif; ?>

    </section>
<?php endif; ?>