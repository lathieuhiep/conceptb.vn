<?php

// Remove jquery migrate
add_action('wp_default_scripts', 'paint_remove_jquery_migrate');
function paint_remove_jquery_migrate($scripts): void
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}

//Register Back-End script
add_action('admin_enqueue_scripts', 'paint_register_back_end_scripts');

function paint_register_back_end_scripts(): void
{

    /* Start Get CSS Admin */
    wp_enqueue_style('paint-admin-styles', get_theme_file_uri('/extension/assets/css/admin-styles.css'));

    /* Start Get Js Admin */
    wp_enqueue_script('admin', get_theme_file_uri('/extension/assets/js/admin.js'), array('jquery'), '', true);
}

//Register Front-End Styles
add_action('wp_enqueue_scripts', 'paint_register_front_end');

function paint_register_front_end(): void
{
    // remove style gutenberg
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style( 'classic-theme-styles' );

    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('storefront-gutenberg-blocks');

    // font google
    $font_url = 'https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap
';

    wp_enqueue_style( 'google-font', $font_url, array(), null );

    // fontawesome
    wp_enqueue_style('fontawesome', get_theme_file_uri('/assets/fonts/fontawesome/css/all.min.css'), array(), '6.7.2');

    // get style bootstrap
    wp_enqueue_style('bootstrap', get_theme_file_uri('/assets/libs/bootstrap/bootstrap.min.css'), array(), '5.3.3');

    // register simplebar
    wp_register_style('simplebar', get_theme_file_uri('/assets/libs/simplebar/simplebar.min.css'), array(), '');
    wp_register_script('simplebar', get_theme_file_uri('/assets/libs/simplebar/simplebar.min.js'), array('jquery'), '', true);

    // style theme
    wp_enqueue_style( 'paint-style', get_theme_file_uri( '/assets/css/style-theme.min.css' ), array(), paint_get_version_theme() );

    // get style lib slick
    if ( is_singular('paint_product') || is_singular('paint_project') || is_singular('paint_tool') || is_singular('paint_discover') || is_singular('post') || is_tax('paint_project_cat') || is_post_type_archive('paint_project') || is_tax('paint_discover_cat') || is_post_type_archive('paint_discover')) {
        wp_enqueue_style('slick-carousel', get_theme_file_uri('/assets/libs/slick-carousel/css/slick.min.css'), array(), '1.8.1');
    }

    if (is_singular('paint_discover')) {
        wp_enqueue_style('lity', get_theme_file_uri('/assets/libs/lity/lity.min.css'), array(), '');
    }

    // get style template introduce
    if (is_page_template('templates/introduce.php')) {
        wp_enqueue_style('template_introduce', get_theme_file_uri('/assets/css/templates/template-introduce.min.css'), array(), '');
    }

    // get style template FAQ
    if (is_page_template('templates/faq.php')) {
        wp_enqueue_style('template_faq', get_theme_file_uri('/assets/css/templates/template-faq.min.css'), array(), '');
    }

    // get style template About Us
    if (is_page_template('templates/about-us.php')) {
        wp_enqueue_style(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(),
            '11'
        );

        wp_enqueue_style('magnific-popup', get_theme_file_uri('/assets/libs/magnific-popup/magnific-popup.min.css'), array(), '');
        wp_enqueue_style('template_about_us', get_theme_file_uri('/assets/css/templates/template-about-us.min.css'), array(), '');
    }

    // get style template Construction
    if (is_page_template('templates/construction.php')) {
        wp_enqueue_style(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(),
            '11'
        );

        wp_enqueue_style('lity', get_theme_file_uri('/assets/libs/lity/lity.min.css'), array(), '');
        wp_enqueue_style('template_construction', get_theme_file_uri('/assets/css/templates/template-construction.min.css'), array(), '');
    }

    // get style archive product
    if (is_tax('paint_product_cat') || is_post_type_archive('paint_product')) {
        wp_enqueue_style('archive-product', get_theme_file_uri('/assets/css/post-type/product/archive.min.css'), array(), '');
    }

    if ( is_singular('paint_product') ) {
        wp_enqueue_style('simplebar');
        wp_enqueue_style('magnific-popup', get_theme_file_uri('/assets/libs/magnific-popup/magnific-popup.min.css'), array(), '');

        wp_enqueue_style('single-product', get_theme_file_uri('/assets/css/post-type/product/single.min.css'), array(), '');
    }

    // get style post type project
    if ( is_tax('paint_project_cat') || is_post_type_archive('paint_project') || ( is_search() && !empty( $_GET['post_type'] ) && $_GET['post_type'] == 'paint_project' ) ) {
        wp_enqueue_style('archive-project', get_theme_file_uri('/assets/css/post-type/project/archive.min.css'), array(), '');
    }

    if ( is_singular('paint_project') ) {
        wp_enqueue_style('simplebar');
        wp_enqueue_style('single-project', get_theme_file_uri('/assets/css/post-type/project/single.min.css'), array(), '');
    }

    // get style post type tool
    if (is_tax('paint_tool_cat') || is_post_type_archive('paint_tool')) {
        wp_enqueue_style('archive-tool', get_theme_file_uri('/assets/css/post-type/tool/archive.min.css'), array(), '');
    }

    if (is_singular('paint_tool')) {
        wp_enqueue_style('single-tool', get_theme_file_uri('/assets/css/post-type/tool/single.min.css'), array(), '');
    }

    // get style post type discover
    if ( is_tax('paint_discover_cat') || is_post_type_archive('paint_discover') || ( is_search() && !empty( $_GET['post_type'] ) && $_GET['post_type'] == 'paint_discover' ) ) {
        wp_enqueue_style('archive-discover', get_theme_file_uri('/assets/css/post-type/discover/archive.min.css'), array(), '');
    }

    if (is_singular('paint_discover')) {
        wp_enqueue_style('single-discover', get_theme_file_uri('/assets/css/post-type/discover/single.min.css'), array(), '');
    }

    // get css single color code
    if (is_singular('paint_color_code')) {
        wp_enqueue_style('magnific-popup', get_theme_file_uri('/assets/libs/magnific-popup/magnific-popup.min.css'), array(), '');
        wp_enqueue_style('single-color-code', get_theme_file_uri('/assets/css/post-type/color-code/single.min.css'), array(), '');
    }

    // get style post
    if (paint_is_blog()) {
        wp_enqueue_style('archive-post', get_theme_file_uri('/assets/css/post-type/post/archive.min.css'), array(), '');
    }

    if (is_singular('post')) {
        wp_enqueue_style('single-post', get_theme_file_uri('/assets/css/post-type/post/single.min.css'), array(), '');
    }

    // get style template register, login
    if (is_page_template('templates/register.php') || is_page_template('templates/login.php') || is_page_template('templates/saved.php') || is_page_template('templates/change-password.php') || is_page_template('templates/personal-info.php')) {
        wp_enqueue_style('template_user', get_theme_file_uri('/assets/css/templates/template-user.min.css'), array(), '');
    }

    // get style template personal-info
    if (is_page_template('templates/personal-info.php') || is_page_template('templates/saved.php') || is_page_template('templates/change-password.php')) {
        wp_enqueue_style('template_acc_info', get_theme_file_uri('/assets/css/templates/template-acc-info.min.css'), array(), '');
    }

    if (is_page_template('templates/home.php')) {
        wp_enqueue_style('splide', get_theme_file_uri('/assets/libs/splide/splide.min.css'), array(), '4.1.2');

        // Swiper CSS
        wp_enqueue_style(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(),
            '11'
        );

        wp_enqueue_style('tpl-home', get_theme_file_uri('/assets/css/templates/tpl-home.min.css'), array(), '');
    }

    /*
    * End Get Css Front End
    * */

    /*
    * Start Get Js Front End
    * */
    // url ajax
    $paint_admin_url_ajax = admin_url('admin-ajax.php');

    // get bootstrap js
    wp_enqueue_script('bootstrap', get_theme_file_uri('/assets/libs/bootstrap/bootstrap.bundle.min.js'), array('jquery'), '5.3.3', true);

    // get lib slick
    if (  is_singular('paint_product') || is_singular('paint_project') || is_singular('paint_tool') || is_singular('paint_discover') || is_singular('post') || is_tax('paint_project_cat') || is_post_type_archive('paint_project') || is_tax('paint_discover_cat') || is_post_type_archive('paint_discover')) {
        wp_enqueue_script('slick-carousel', get_theme_file_uri('/assets/libs/slick-carousel/js/slick.min.js'), array('jquery'), '1.8.1', true);
    }

    // get lib lity
    if (is_singular('paint_discover') || is_page_template('templates/construction.php')) {
        wp_enqueue_script('lity', get_theme_file_uri('/assets/libs/lity/lity.min.js'), array('jquery'), '', true);
    }

    if (is_page_template('templates/construction.php')) {
        wp_enqueue_script(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11',
            true
        );

        wp_add_inline_script(
            'swiper',
            "document.addEventListener('DOMContentLoaded',function(){if(typeof window.Swiper!=='function'){return;}document.querySelectorAll('[data-construction-tools-slider]').forEach(function(slider){var swiperEl=slider.querySelector('[data-construction-tools-swiper]');if(!swiperEl||swiperEl.classList.contains('swiper-initialized')){return;}var desktopSlides=parseInt(slider.getAttribute('data-slides-per-view')||'1',10);var slideCount=swiperEl.querySelectorAll('.swiper-slide').length;var options={slidesPerView:1,spaceBetween:0,loop:slideCount>desktopSlides,speed:500,autoHeight:true,watchOverflow:true,navigation:{prevEl:slider.querySelector('.construction-tools__nav--prev'),nextEl:slider.querySelector('.construction-tools__nav--next')}};if(desktopSlides>1){options.spaceBetween=12;options.autoHeight=false;options.breakpoints={568:{slidesPerView:2,spaceBetween:12},992:{slidesPerView:desktopSlides,spaceBetween:12}};}new window.Swiper(swiperEl,options);});});"
        );

        wp_add_inline_script(
            'swiper',
            "document.addEventListener('DOMContentLoaded',function(){var nav=document.querySelector('[data-construction-anchor-nav]');var hero=document.querySelector('.construction-hero');if(!nav||!hero||!('IntersectionObserver'in window)){return;}var observer=new IntersectionObserver(function(entries){entries.forEach(function(entry){nav.classList.toggle('is-stuck',!entry.isIntersecting);});},{rootMargin:'-120px 0px 0px 0px',threshold:0});observer.observe(hero);});"
        );
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('paint-custom', get_theme_file_uri('/assets/js/custom.min.js'), array(), '1.0.0', true);

    // get js template
    if ( is_page_template('templates/introduce.php')) {
        wp_enqueue_script('count-up-scroll', get_theme_file_uri('/assets/js/count-up-scroll.min.js'), array('jquery'), '', true);
    }

    if (is_page_template('templates/faq.php')) {
        wp_enqueue_script('template-faq', get_theme_file_uri('/assets/js/template-faq.min.js'), array(), '1.0.0', true);
        wp_localize_script('template-faq', 'faqAjax', array(
            'url' => $paint_admin_url_ajax,
            'nonce' => wp_create_nonce('paint_faq_nonce'),
        ));
    }

    if (is_page_template('templates/about-us.php')) {
        wp_enqueue_script(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11',
            true
        );

        wp_enqueue_script('magnific-popup', get_theme_file_uri('/assets/libs/magnific-popup/jquery.magnific-popup.min.js'), array('jquery'), '', true);
        wp_enqueue_script('template-about-us', get_theme_file_uri('/assets/js/template-about-us.min.js'), array('jquery', 'bootstrap', 'swiper', 'magnific-popup'), '1.0.0', true);
    }

    if ( is_singular('paint_product') ) {
        wp_enqueue_script('simplebar');
        wp_enqueue_script('masonry.min', get_theme_file_uri('/assets/libs/masonry/masonry.min.js'), array('jquery'), '', true);
        wp_enqueue_script('magnific-popup', get_theme_file_uri('/assets/libs/magnific-popup/jquery.magnific-popup.min.js'), array('jquery'), '', true);

        wp_enqueue_script('product-detail', get_theme_file_uri('/assets/js/product-detail.min.js'), array(), '1.0.0', true);
        wp_localize_script('product-detail', 'productDetailAjax', array('url' => $paint_admin_url_ajax));
    }

    // template discover
    if ( is_tax('paint_discover_cat') || is_post_type_archive('paint_discover') || is_singular('paint_discover') || ( is_search() && !empty( $_GET['post_type'] ) && $_GET['post_type'] == 'paint_discover' ) ) {
        wp_enqueue_script('masonry.min', get_theme_file_uri('/assets/libs/masonry/masonry.min.js'), array('jquery'), '', true);
        wp_enqueue_script('discover', get_theme_file_uri('/assets/js/discover.min.js'), array(), '1.0.0', true);
        wp_localize_script('discover', 'discoverAjax', array('url' => $paint_admin_url_ajax));
    }

    if (is_singular(array('paint_discover', 'paint_project'))) {
        wp_enqueue_script('user-save', get_theme_file_uri('/assets/js/user-save.min.js'), array(), '1.0.0', true);
        wp_localize_script('user-save', 'userSaveAjax', array('url' => $paint_admin_url_ajax));
    }

    if ( is_singular('paint_project') ) {
        wp_enqueue_script('simplebar');
        wp_enqueue_script('project-detail', get_theme_file_uri('/assets/js/project-detail.min.js'), array(), '', true);
    }

    if (is_singular('paint_color_code')) {
        wp_enqueue_script('magnific-popup', get_theme_file_uri('/assets/libs/magnific-popup/jquery.magnific-popup.min.js'), array('jquery'), '', true);
        wp_enqueue_script('color-code-detail', get_theme_file_uri('/assets/js/color-code-detail.min.js'), array(), '1.0.0', true);
    }

    // template register
    if (is_page_template('templates/register.php')) {
        wp_enqueue_script('cleave.min', get_theme_file_uri('/assets/libs/cleave/cleave.min.js'), array(), '1.6.0', true);
        wp_enqueue_script('jquery.validate.min', get_theme_file_uri('/assets/libs/validate/jquery.validate.min.js'), array(), '1.19.5', true);
        wp_enqueue_script('template-register', get_theme_file_uri('/assets/js/template-register.min.js'), array(), '', true);
    }

    // template login
    if (is_page_template('templates/login.php')) {
        wp_enqueue_script('jquery.validate.min', get_theme_file_uri('/assets/libs/validate/jquery.validate.min.js'), array(), '1.19.5', true);
        wp_enqueue_script('template-login', get_theme_file_uri('/assets/js/template-login.min.js'), array(), '1.0.0', true);
        wp_localize_script('template-login', 'loginAjax', array('url' => $paint_admin_url_ajax));
    }

    // template personal info
    if (is_page_template('templates/personal-info.php')) {
        wp_enqueue_script('cleave.min', get_theme_file_uri('/assets/libs/cleave/cleave.min.js'), array(), '1.6.0', true);
        wp_enqueue_script('jquery.validate.min', get_theme_file_uri('/assets/libs/validate/jquery.validate.min.js'), array(), '1.19.5', true);
        wp_enqueue_script('template-personal-info', get_theme_file_uri('/assets/js/template-personal-info.min.js'), array(), '', true);
    }

    // template change password
    if (is_page_template('templates/change-password.php')) {
        wp_enqueue_script('jquery.validate.min', get_theme_file_uri('/assets/libs/validate/jquery.validate.min.js'), array(), '1.19.5', true);
        wp_enqueue_script('template-change-password', get_theme_file_uri('/assets/js/template-change-password.min.js'), array(), '1.0.0', true);
        wp_localize_script('template-change-password', 'changePasswordAjax', array('url' => $paint_admin_url_ajax));
    }

    // template user saved
    if (is_page_template('templates/saved.php')) {
        wp_enqueue_script('masonry.min', get_theme_file_uri('/assets/libs/masonry/masonry.min.js'), array('jquery'), '', true);
        wp_enqueue_script('template-user-saved', get_theme_file_uri('/assets/js/template-user-saved.min.js'), array(), '1.0.0', true);
        wp_localize_script('template-user-saved', 'templateUserSaveAjax', array('url' => $paint_admin_url_ajax));
    }

    // template home
    if (is_page_template('templates/home.php')) {
        wp_enqueue_script('splide', get_theme_file_uri('/assets/libs/splide/splide.min.js'), array(), '4.1.2', true);

        wp_enqueue_script('splide-extension-auto-scroll',
            get_theme_file_uri('/assets/libs/splide/splide-extension-auto-scroll.min.js'),
            array('splide'), '0.5.3', true
        );

        // Swiper JS
        wp_enqueue_script(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11',
            true
        );

        // GSAP core
        wp_enqueue_script(
            'gsap',
            'https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js',
            array('jquery'),
            '3.14.1',
            true
        );

        // ScrollTrigger plugin
        wp_enqueue_script(
            'ScrollTrigger',
            'https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrollTrigger.min.js',
            array('jquery', 'gsap'),
            '3.14.1',
            true
        );

        wp_enqueue_script(
            'SplitText',
            'https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/SplitText.min.js',
            array('jquery', 'gsap'),
            '3.14.1',
            true
        );

        wp_enqueue_script('tpl-home',
            get_theme_file_uri('/assets/js/tpl-home.min.js'),
            array('jquery', 'splide', 'splide-extension-auto-scroll', 'swiper', 'gsap', 'ScrollTrigger', 'SplitText'),
            '1.0.0', true
        );
    }

    /*
   * End Get Js Front End
   * */

}
