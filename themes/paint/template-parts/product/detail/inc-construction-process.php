<?php
use ExtendSite\Admin\Fields\Product\ProductConstructionTab;

$idProduct = (int) ($args['idProduct'] ?? 0);

if (!$idProduct || !class_exists(ProductConstructionTab::class)) {
    return;
}

$construction_data = ProductConstructionTab::get_data($idProduct);
$overview_content = !empty($construction_data['overview_content']) ? (string) $construction_data['overview_content'] : '';
$opt_process = !empty($construction_data['construction_process']) && is_array($construction_data['construction_process'])
    ? $construction_data['construction_process']
    : [];

if ($overview_content === '' && empty($opt_process)) {
    return;
}
?>

<div class="construction-process-product">
    <?php if ($overview_content !== '') : ?>
        <div class="construction-process-product__overview">
            <?php echo wp_kses_post(wpautop($overview_content)); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($opt_process)) : ?>
        <div class="accordion accordion-process" id="accordionProcess">
            <?php foreach ($opt_process as $key => $item) : ?>
                <?php
                $number = (int) ($item['number'] ?? ($key + 1));
                $title = !empty($item['title']) ? (string) $item['title'] : (string) ($item['step'] ?? '');
                $subtitle = !empty($item['subtitle']) ? (string) $item['subtitle'] : '';
                $layout = !empty($item['layout']) ? (string) $item['layout'] : 'content';
                $content = !empty($item['content']) ? (string) $item['content'] : '';
                $before_content = !empty($item['before_content']) ? (string) $item['before_content'] : '';
                $after_content = !empty($item['after_content']) ? (string) $item['after_content'] : '';
                $cards = !empty($item['cards']) && is_array($item['cards']) ? $item['cards'] : [];
                $columns = !empty($item['columns']) && is_array($item['columns']) ? $item['columns'] : [];
                $image_id = !empty($item['image_id']) ? (int) $item['image_id'] : 0;
                $collapse_id = 'collapse-process-' . $idProduct . '-' . $key;
                $heading_id = 'heading-process-' . $idProduct . '-' . $key;
                $is_active = $key === 0;
                ?>

                <div class="accordion-item construction-process-step construction-process-step--<?php echo esc_attr($layout); ?>">
                    <h2 class="accordion-header" id="<?php echo esc_attr($heading_id); ?>">
                        <button class="accordion-button<?php echo $is_active ? '' : ' collapsed'; ?>"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#<?php echo esc_attr($collapse_id); ?>"
                                aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
                                aria-controls="<?php echo esc_attr($collapse_id); ?>">
                            <span class="construction-process-step__number">
                                <?php echo esc_html($number); ?>
                            </span>

                            <span class="construction-process-step__heading">
                                <span class="construction-process-step__title">
                                    <?php echo esc_html($title); ?>
                                </span>

                                <?php if ($subtitle !== '') : ?>
                                    <span class="construction-process-step__subtitle">
                                        <?php echo esc_html($subtitle); ?>
                                    </span>
                                <?php endif; ?>
                            </span>
                        </button>
                    </h2>

                    <div id="<?php echo esc_attr($collapse_id); ?>"
                         class="accordion-collapse collapse<?php echo $is_active ? ' show' : ''; ?>"
                         aria-labelledby="<?php echo esc_attr($heading_id); ?>"
                         data-bs-parent="#accordionProcess">
                        <div class="accordion-body">
                            <?php if ($layout === 'cards' && !empty($cards)) : ?>
                                <div class="construction-process-cards">
                                    <?php foreach ($cards as $card) : ?>
                                        <article class="construction-process-card">
                                            <?php if (!empty($card['image_id'])) : ?>
                                                <figure class="construction-process-card__image">
                                                    <?php echo wp_get_attachment_image((int) $card['image_id'], 'medium_large'); ?>
                                                </figure>
                                            <?php endif; ?>

                                            <div class="construction-process-card__body">
                                                <?php if (!empty($card['title'])) : ?>
                                                    <h3 class="construction-process-card__title">
                                                        <?php echo esc_html($card['title']); ?>
                                                    </h3>
                                                <?php endif; ?>

                                                <?php if (!empty($card['content'])) : ?>
                                                    <div class="construction-process-card__content">
                                                        <?php echo wp_kses_post(wpautop((string) $card['content'])); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif ($layout === 'image_columns' && ($image_id || !empty($columns) || $before_content !== '' || $after_content !== '')) : ?>
                                <div class="construction-process-image-columns">
                                    <?php if ($image_id) : ?>
                                        <figure class="construction-process-image-columns__image">
                                            <?php echo wp_get_attachment_image($image_id, 'large'); ?>
                                        </figure>
                                    <?php endif; ?>

                                    <div class="construction-process-image-columns__body">
                                        <?php if ($before_content !== '') : ?>
                                            <div class="construction-process-image-columns__intro">
                                                <?php echo wp_kses_post(wpautop($before_content)); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($columns)) : ?>
                                            <div class="construction-process-image-columns__table">
                                                <?php foreach ($columns as $column) : ?>
                                                    <section class="construction-process-image-columns__column">
                                                        <?php if (!empty($column['title'])) : ?>
                                                            <h3 class="construction-process-image-columns__title">
                                                                <?php echo esc_html($column['title']); ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <?php if (!empty($column['content'])) : ?>
                                                            <div class="construction-process-image-columns__content">
                                                                <?php echo wp_kses_post(wpautop((string) $column['content'])); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </section>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($after_content !== '') : ?>
                                            <div class="construction-process-image-columns__outro">
                                                <?php echo wp_kses_post(wpautop($after_content)); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php elseif ($content !== '') : ?>
                                <div class="construction-process-step__content">
                                    <?php echo wp_kses_post(wpautop($content)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
