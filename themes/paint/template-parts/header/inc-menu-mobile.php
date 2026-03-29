<div class="offcanvas offcanvas-start offcanvas-menu-mobile" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-uppercase" id="staticBackdropLabel">
            <?php esc_html_e('Danh mục', 'paint'); ?>
        </h5>

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa fa-close"></i>
        </button>
    </div>

    <div class="offcanvas-body">
        <?php
        if ( has_nav_menu( 'primary' ) ) :
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class' => 'd-lg-flex reset-list',
                'container' => false,
            ) );
        endif;
        ?>
    </div>
</div>