<?php
$image_hover = get_post_meta(get_the_ID(), 'paint_cmb_product_image_feature_hover', true);
$color_board = (int)get_post_meta(get_the_ID(), 'paint_cmb_options_product_color', true);
?>

<div class="item">
    <a class="item__link" href="<?php the_permalink(); ?>"></a>

    <div class="item__image">
        <?php
        $attr = array(
            'class' => 'featured-image w-100'
        );

        the_post_thumbnail('large', $attr);
        ?>

        <?php if ( $image_hover ) : ?>
            <div class="secondary-image">
                <img src="<?php echo esc_url( $image_hover ); ?>" alt="<?php the_title() ?>" width="768">
            </div>
        <?php endif; ?>
    </div>

    <h3 class="item__title text-center">
        <?php the_title(); ?>
    </h3>
</div>