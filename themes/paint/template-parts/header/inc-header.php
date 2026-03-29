<?php
use ExtendSite\Admin\Fields\Pages\Default\MenuTab;

// Global options
$sticky_menu = paint_get_option('general_option_menu_sticky', true);
$logo = paint_get_option('general_opt_logo', '');
$opt_social_networks = paint_get_option('paint_opt_social_network', []);

$class_menu = ['site-header'];

// Page context
$page_id = get_queried_object_id();

// Lấy menu data từ Page (Carbon Fields qua Tab)
$menu_data = $page_id ? paint_get_field_tab_data(MenuTab::class, $page_id) : [];

$menu_style    = $menu_data['style'] ?? '';
$menu_position = $menu_data['position'] ?? '';

// Menu style (per page)
if ($menu_style === 'v-1') {
    $class_menu[] = 'menu-style-v1';
}

// Menu position (ưu tiên page → fallback global)
if (! empty($menu_position)) {
    $class_menu[] = 'menu-position-' . sanitize_html_class($menu_position);
} elseif ($sticky_menu) {
    $class_menu[] = 'menu-position-sticky';
}
?>

<header class="<?php echo esc_attr( implode( ' ', $class_menu ) ) ?>">
    <nav class="main-navigation">
        <div class="container">
            <div class="site-navbar">
                <div class="site-logo d-flex align-items-center">
                    <button class="btn btn-primary btn-close-canvas d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>

                    <a href="<?php echo esc_url(get_home_url('/')); ?>" title="<?php bloginfo('name'); ?>">
                        <?php
                        if (!empty($logo['id'])) :
                            echo wp_get_attachment_image($logo['id'], 'medium');
                        else :
                            ?>
                            <img class="logo-default"
                                 src="<?php echo esc_url(get_theme_file_uri('/assets/images/logo.png')) ?>"
                                 alt="<?php echo esc_attr(get_bloginfo('title')); ?>" />

                        <?php endif; ?>
                    </a>
                </div>

                <div id="site-menu" class="site-menu navbar-collapse d-lg-flex">
                    <?php
                    if (has_nav_menu('primary')) :

                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class' => 'navbar-nav flex-lg-row',
                            'container' => false,
                        ));

                    else:
                        ?>
                        <ul class="main-menu">
                            <li>
                                <a href="<?php echo get_admin_url() . '/nav-menus.php'; ?>">
                                    <?php esc_html_e('ADD TO MENU', 'paint'); ?>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>

                    <div class="search-box-warp">
                        <?php get_template_part('searchform', 'header'); ?>
                    </div>
                </div>

                <div class="box-action d-flex align-items-center gap-4">
                    <div class="search-header-warp d-flex align-items-center">
                        <button type="button" id="btn-header-search" class="btn btn-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>

                    <?php if ( !empty( $opt_social_networks ) && !empty( $opt_social_networks['facebook'] ) ) : ?>
                        <div class="social-header-warp d-flex align-items-center">
                            <a href="<?php echo esc_url( $opt_social_networks['facebook'] ); ?>" target="_blank" class="btn btn-social">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="dropdown-account-warp position-relative text-center d-flex align-items-center">
                        <button type="button" id="btn-header-account" class="btn btn-account">
                            <i class="fa-regular fa-user"></i>
                        </button>

                        <div id="dropdown-user-manager" class="dropdown-user-manager">
                            <i class="fa-solid fa-circle-user"></i>

                            <div class="details">
                                <p class="title"><?php esc_html_e( 'Tài khoản của tôi', 'paint' ); ?></p>

                                <?php
                                if ( is_user_logged_in() ):
                                    $current_user = wp_get_current_user();
                                ?>
                                    <span class="txt user-name"><?php echo esc_html($current_user->user_nicename); ?></span>

                                    <div class="account-footer d-flex justify-content-between align-items-center">
                                        <div class="account-footer__item">
                                            <a class="logout d-flex align-items-center gap-2" href="<?php echo wp_logout_url(home_url()); ?>">
                                                <i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180"></i>
                                                <span><?php esc_html_e('Đăng xuất', 'paint'); ?></span>
                                            </a>
                                        </div>

                                        <div class="account-footer__item">
                                            <a href="<?php echo esc_url(paint_get_tpl_url('templates/personal-info.php')); ?>">
                                                <i class="fa-solid fa-user-pen"></i>
                                                <span><?php esc_html_e('Thông tin', 'paint'); ?></span>
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <a id="btn-login-user" class="btn btn-login-user" href="<?php echo esc_url(paint_get_tpl_url('templates/login.php')) ?>">
                                        <?php esc_html_e( 'Đăng nhập', 'paint' ); ?>
                                    </a>

                                    <div class="register-warp d-flex align-items-center gap-2">
                                        <span class="txt"><?php esc_html_e( 'Chưa có tài khoản?', 'paint' ); ?></span>

                                        <a id="btn-register-user" class="btn btn-register-user" href="<?php echo esc_url(paint_get_tpl_url('templates/register.php')); ?>">
                                            <?php esc_html_e( 'Đăng ký tại đây', 'paint' ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>