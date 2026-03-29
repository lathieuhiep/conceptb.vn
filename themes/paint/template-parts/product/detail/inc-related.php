<?php
$query = new WP_Query(array(
    'post_type' => 'paint_product',
    'posts_per_page' => 4,
    'post__not_in' => array(get_the_ID()),
    'ignore_sticky_posts' => 1,
));

if ( $query->have_posts() ) :
?>
    <div class="related-product">
        <h3 class="related-product__title">
            <?php esc_html_e('Xem sản phẩm tương tự', 'paint'); ?>
        </h3>

        <div class="related-product__grid owl-carousel">
            <?php
            while ($query->have_posts()) :
                $query->the_post();
                $image_secondary = get_post_meta(get_the_ID(), 'paint_cmb_product_image_feature_hover', true);
            ?>

            <div class="item">
                <div class="item__thumbnail">
                    <?php if ( $image_secondary ) : ?>
                        <img src="<?php echo esc_url( $image_secondary ); ?>" alt="" width="768">
                    <?php
                    else:
                        the_post_thumbnail('medium_large');
                    ?>
                    <?php endif; ?>
                </div>

                <h3 class="title">
                    <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                </h3>

                <div class="action-box">
                    <a class="link-detail" href="<?php the_permalink(); ?>"><?php esc_html_e('Chi tiết', 'paint'); ?></a>
                </div>
            </div>

            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
<?php
endif;
