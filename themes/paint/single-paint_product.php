<?php get_header(); ?>

    <div class="site-container site-single-product font-f-seconder" data-product-id="<?php echo esc_attr(get_the_ID()) ?>">
        <div class="container">
            <div class="row">
                <?php if (is_active_sidebar('paint-sidebar-product-detail')) : ?>
                    <div class="<?php echo esc_attr(paint_col_sidebar()); ?> site-sidebar-product-detail">
                        <aside class="site-sidebar">
                            <?php dynamic_sidebar('paint-sidebar-product-detail'); ?>
                        </aside>
                    </div>
                <?php endif; ?>

                <div class="<?php echo is_active_sidebar('paint-sidebar-product-detail') ? 'col-12 col-md-8 col-lg-9' : 'col-12'; ?>">
                    <?php
                    while (have_posts()) :
                        the_post();

                        get_template_part('template-parts/product/detail/inc', 'info');
                        get_template_part('template-parts/product/detail/inc', 'tabs');

                    endwhile;

                    get_template_part('template-parts/product/detail/inc', 'related');
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
