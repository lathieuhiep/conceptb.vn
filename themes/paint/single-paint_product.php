<?php
use ExtendSite\Admin\Fields\Product\ProductMediaTab;

get_header();

$product_id = get_the_ID();
$banner_id = class_exists(ProductMediaTab::class) ? ProductMediaTab::get_banner_id($product_id) : 0;
?>

    <?php if ($banner_id) : ?>
        <div class="product-banner element-banner">
            <?php echo wp_get_attachment_image($banner_id, 'full', false, [
                'class' => 'w-100',
            ]); ?>
        </div>
    <?php endif; ?>

    <div class="site-single-product font-f-seconder" data-product-id="<?php echo esc_attr(get_the_ID()) ?>">
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
                    <div class="product-detail-warp">
                        <?php
                        while (have_posts()) :
                            the_post();

                            get_template_part('template-parts/product/detail/inc', 'info');
                            get_template_part('template-parts/product/detail/inc', 'tabs');
                        endwhile;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
