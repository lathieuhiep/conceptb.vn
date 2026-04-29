<div class="site-footer__copyright">
    <div class="warp">
        <div class="m-0 text-center box">
            <?php
            echo wp_kses_post(
                paint_get_option(
                    'paint_opt_footer_copyright',
                    esc_html__('@copyright 2025 all right reserved by BeeColor Viet Nam', 'paint')
                )
            );
            ?>
        </div>
    </div>
</div>
