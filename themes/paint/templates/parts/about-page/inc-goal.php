<?php

use ExtendSite\Admin\Fields\Pages\About\GoalTab;

$data = paint_get_field_tab_data(GoalTab::class);
$title = $data['title'] ?? '';
$lead = $data['lead'] ?? '';
$description = $data['description'] ?? '';
$items = $data['items'] ?? [];

if ($title === '' && $lead === '' && $description === '' && empty($items)) {
    return;
}
?>

<section class="about-goal">
    <div class="about-container">
        <div class="about-goal__inner">
            <div class="about-goal__content">
                <?php if ($title !== '') : ?>
                    <h2 class="about-goal__title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($lead !== '') : ?>
                    <p class="about-goal__lead"><?php echo esc_html($lead); ?></p>
                <?php endif; ?>

                <?php if ($description !== '') : ?>
                    <p class="about-goal__desc"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($items)) : ?>
                <div class="about-goal__cards">
                    <?php foreach ($items as $item) : ?>
                        <?php
                        $item_title = trim((string)($item['title'] ?? ''));
                        $label = trim((string)($item['label'] ?? ''));
                        $value = trim((string)($item['metric'] ?? ($item['value'] ?? '')));
                        $item_desc = trim((string)($item['description'] ?? ''));

                        if ($item_title === '' && $label === '' && $value === '' && $item_desc === '') {
                            continue;
                        }
                        ?>

                        <article class="about-goal-card">
                            <?php if ($item_title !== '') : ?>
                                <h3 class="about-goal-card__title"><?php echo esc_html($item_title); ?></h3>
                            <?php endif; ?>

                            <span class="about-goal-card__line" aria-hidden="true"></span>

                            <?php if ($label !== '') : ?>
                                <p class="about-goal-card__label"><?php echo esc_html($label); ?></p>
                            <?php endif; ?>

                            <?php if ($value !== '') : ?>
                                <strong class="about-goal-card__value"><?php echo esc_html($value); ?></strong>
                            <?php endif; ?>

                            <?php if ($item_desc !== '') : ?>
                                <p class="about-goal-card__desc"><?php echo esc_html($item_desc); ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
