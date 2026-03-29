<?php get_header(); ?>

    <div class="site-container site-single-product font-f-seconder" data-product-id="<?php echo esc_attr(get_the_ID()) ?>">
        <div class="container">
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

<?php
get_footer();