<?php
$opt_footer_column = paint_get_option('paint_opt_footer_columns', '4');

if ($opt_footer_column == 0) {
    return false;
}

if (is_active_sidebar('paint-sidebar-footer-column-1') || is_active_sidebar('paint-sidebar-footer-column-2') || is_active_sidebar('paint-sidebar-footer-column-3') || is_active_sidebar('paint-sidebar-footer-column-4')) :
    ?>
    <div class="site-footer__column">
        <div class="warp">
            <div class="row row-gap-5">
                <?php
                for ($i = 0; $i < $opt_footer_column; $i++):
                    $j = $i + 1;
                    $paint_col = paint_get_option('paint_opt_footer_column_width_' . $j, 4);
                    $sm = $paint_col['sm'] ?? 12;
                    $md = $paint_col['md'] ?? 6;
                    $lg = $paint_col['lg'] ?? 3;
                    $xl = $paint_col['xl'] ?? 3;

                    if (is_active_sidebar('paint-sidebar-footer-column-' . $j)):
                        ?>
                        <div class="row-gap-5 row-gap-md-14 d-flex flex-column col-12 col-sm-<?php echo esc_attr($sm) ?> col-md-<?php echo esc_attr($md) ?> col-lg-<?php echo esc_attr($lg) ?> col-xl-<?php echo esc_attr($xl); ?>">
                            <?php dynamic_sidebar('paint-sidebar-footer-column-' . $j); ?>
                        </div>
                    <?php
                    endif;
                endfor;
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>