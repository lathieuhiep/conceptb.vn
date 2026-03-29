<?php
$terms = get_the_terms(get_the_ID(), 'paint_project_cat');
?>

<div class="item">
    <div class="thumbnail">
        <a class="link-image" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('medium_large'); ?>
        </a>
    </div>

    <div class="content-box">
        <div class="content-box__top">
            <h2 class="title text-center">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title() ?>
                </a>
            </h2>

            <?php if ($terms) : ?>
                <div class="line"></div>

                <div class="tax">
                    <?php foreach ($terms as $term) : ?>
                        <a href="<?php echo esc_url(get_term_link($term->slug, 'paint_project_cat')); ?>">
                            <?php echo esc_html($term->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="link-detail">
            <?php esc_html_e('Xem chi tiết', 'paint'); ?>
        </a>
    </div>
</div>
