<?php get_header(); ?>

<div class="site-single-color-code-warp">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();

            $color_code_name = get_post_meta(get_the_ID(), 'paint_cmb_color_code_name', true);
            $color_code_list = get_post_meta(get_the_ID(), 'paint_cmb_color_code_standard', true);
        ?>

        <h1 class="title">
            <?php the_title() ?>
        </h1>

        <?php if (!empty($color_code_name)) : ?>
            <p class="name">
                <strong><?php esc_html_e('Tên hiệu: ', 'paint'); ?></strong>
                <?php echo esc_html($color_code_name); ?>
            </p>
        <?php endif; ?>

        <div class="color-table">
            <h4 class="color-table__title">
                <?php esc_html_e('Bảng màu', 'paint'); ?>
            </h4>

            <?php if ( $color_code_list ) : ?>

            <div class="color-table__grid">
                <?php foreach ( $color_code_list as $item ): ?>
                <div class="item">
                    <div class="item__thumbnail">
                        <a class="img-link" href="<?php echo esc_url( wp_get_attachment_url($item['image_id']) ); ?>">
                            <?php echo wp_get_attachment_image( $item['image_id'], 'medium' ); ?>
                        </a>
                    </div>

                    <p class="paint-number fw-bold text-center">
                        <?php echo esc_html($item['paint_number']) ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>

            <?php endif; ?>
        </div>

        <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>

<?php
get_footer();