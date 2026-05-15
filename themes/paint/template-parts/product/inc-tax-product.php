<?php
use ExtendSite\Admin\Fields\Product\ProductMediaTab;

$image_hover = class_exists(ProductMediaTab::class) ? ProductMediaTab::get_image_hover_id(get_the_ID()) : 0;
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
                <?php echo wp_get_attachment_image($image_hover, 'large'); ?>
            </div>
        <?php endif; ?>
    </div>

    <h3 class="item__title text-center">
        <?php the_title(); ?>
    </h3>
</div>
