<?php
use ExtendSite\Admin\Fields\Product\ProductInfoTab;

$product_id = get_the_ID();
$main_image_id = (int) get_post_thumbnail_id($product_id);
$product_info = class_exists(ProductInfoTab::class) ? ProductInfoTab::get_data($product_id) : [];

$technical_specs = !empty($product_info['technical_specs']) ? $product_info['technical_specs'] : [];
$intro = !empty($product_info['intro']) && is_array($product_info['intro']) ? $product_info['intro'] : [];
$intro_title = !empty($intro['title']) ? (string) $intro['title'] : '';
$intro_content = !empty($intro['content']) ? (string) $intro['content'] : '';
$construction_notes = !empty($product_info['construction_notes']) ? (string) $product_info['construction_notes'] : '';

$info_tabs = [];

if (!empty($technical_specs)) {
    $info_tabs[] = [
        'id' => 'product-specification',
        'button_id' => 'product-specification-tab',
        'label' => __('Thông số kỹ thuật', 'paint'),
        'type' => 'technical_specs',
    ];
}

if ($intro_title !== '' || trim(wp_strip_all_tags($intro_content)) !== '') {
    $info_tabs[] = [
        'id' => 'product-introduction',
        'button_id' => 'product-introduction-tab',
        'label' => __('Giới thiệu', 'paint'),
        'type' => 'intro',
    ];
}

if (trim(wp_strip_all_tags($construction_notes)) !== '') {
    $info_tabs[] = [
        'id' => 'product-note',
        'button_id' => 'product-note-tab',
        'label' => __('Lưu ý thi công', 'paint'),
        'type' => 'construction_notes',
    ];
}
?>

<h1 class="product-title product-info-detail__title">
    <?php the_title(); ?>
</h1>

<div class="product-info-warp product-info-detail">
    <div class="thumbnail-box product-info-detail__media">
        <?php if ($main_image_id) : ?>
            <a class="product-info-detail__image zoom-box" href="<?php echo esc_url(wp_get_attachment_url($main_image_id)); ?>">
                <?php echo wp_get_attachment_image($main_image_id, 'large'); ?>
            </a>
        <?php endif; ?>
    </div>

    <div class="body-box product-info-detail__body">
        <?php if (!empty($info_tabs)) : ?>
            <div class="product-info-tabs">
                <ul class="product-info-tabs__nav nav nav-pills" id="product-info-tab" role="tablist">
                    <?php foreach ($info_tabs as $index => $info_tab) : ?>
                        <?php $is_active = $index === 0; ?>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo $is_active ? 'active' : ''; ?>"
                                    id="<?php echo esc_attr($info_tab['button_id']); ?>"
                                    data-bs-toggle="pill"
                                    data-bs-target="#<?php echo esc_attr($info_tab['id']); ?>"
                                    type="button"
                                    role="tab"
                                    aria-controls="<?php echo esc_attr($info_tab['id']); ?>"
                                    aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
                                <?php echo esc_html($info_tab['label']); ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="product-info-tabs__content tab-content" id="product-info-tabContent">
                    <?php foreach ($info_tabs as $index => $info_tab) : ?>
                        <?php $is_active = $index === 0; ?>

                        <div class="tab-pane fade <?php echo $is_active ? 'show active' : ''; ?>"
                             id="<?php echo esc_attr($info_tab['id']); ?>"
                             role="tabpanel"
                             aria-labelledby="<?php echo esc_attr($info_tab['button_id']); ?>"
                             tabindex="0">
                            <?php if ($info_tab['type'] === 'technical_specs') : ?>
                                <div class="product-spec-table">
                                    <?php foreach ($technical_specs as $technical_spec) : ?>
                                        <div class="product-spec-table__row">
                                            <div class="product-spec-table__label">
                                                <?php echo esc_html($technical_spec['label'] ?? ''); ?>
                                            </div>

                                            <div class="product-spec-table__value">
                                                <?php echo esc_html($technical_spec['value'] ?? ''); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif ($info_tab['type'] === 'intro') : ?>
                                <div class="product-info-tabs__text">
                                    <?php if ($intro_title !== '') : ?>
                                        <h2><?php echo esc_html($intro_title); ?></h2>
                                    <?php endif; ?>

                                    <div class="desc">
                                        <?php echo wp_kses_post(wpautop($intro_content)); ?>
                                    </div>
                                </div>
                            <?php elseif ($info_tab['type'] === 'construction_notes') : ?>
                                <div class="product-info-tabs__text">
                                    <?php echo wp_kses_post(wpautop($construction_notes)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
