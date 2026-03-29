<?php
function paint_custom_elementor_content_width(): int
{
    return 1200;
}
add_filter( 'hello_elementor_content_width', 'paint_custom_elementor_content_width' );

// Register Category Elementor Addon
add_action( 'elementor/elements/categories_registered', 'paint_add_elementor_widget_categories' );
function paint_add_elementor_widget_categories( $elements_manager ): void {
	$elements_manager->add_category(
		'my-theme',
		[
			'title' => esc_html__( 'My Theme', 'paint' ),
			'icon'  => 'icon-goes-here',
		]
	);
}

// Register widgets
add_action( 'elementor/widgets/register', 'paint_register_widget_elementor_addon' );
function paint_register_widget_elementor_addon( $widgets_manager ): void {
	// include new add on
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/hero-banner.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/marquee.php' );

    // include old add on
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/about-slider.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/album-gallery.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/contact-form-7.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/heading-between-line.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/image-grid-box.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/product-grid.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/image-grid-overlay.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/gallery-grid-box.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/post-carousel.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/slider.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/slider-carousel.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/count-up.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/content-box-grid.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/tool-carousel.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/commit-box-grid.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/project-carousel.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/procedure-carousel.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/color-code-carousel.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/discover-grid.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/introduce.php' );
    require get_parent_theme_file_path( '/extension/elementor-addon/widgets/image-carousel.php' );

	// register new add on
    $widgets_manager->register( new \Paint_Hero_Banner_Widget() );
    $widgets_manager->register( new \Paint_Elementor_Marquee() );

    // register old add on
    $widgets_manager->register( new \Paint_Elementor_About_Slider() );
    $widgets_manager->register( new \Paint_Elementor_Album_Gallery() );
    $widgets_manager->register( new \Paint_Elementor_Contact_Form_7() );
    $widgets_manager->register( new \Paint_Elementor_Heading_Between_Line() );
    $widgets_manager->register( new \Paint_Elementor_Image_Grid_Box() );
    $widgets_manager->register( new \Paint_Elementor_Product_Grid() );
    $widgets_manager->register( new \Paint_Elementor_Image_Grid_Overlay() );
    $widgets_manager->register( new \Paint_Elementor_Gallery_Grid_Box() );
    $widgets_manager->register( new \Paint_Elementor_Post_Carousel() );
    $widgets_manager->register( new \Paint_Elementor_Slider() );
    $widgets_manager->register( new \Paint_Elementor_Slider_Carousel() );
    $widgets_manager->register( new \Paint_Elementor_Count_Up() );
    $widgets_manager->register( new \Paint_Elementor_Content_Box_Grid() );
    $widgets_manager->register( new \Paint_Elementor_Tool_Carousel() );
    $widgets_manager->register( new \Paint_Elementor_Commit_Box_Grid() );
    $widgets_manager->register( new \Paint_Elementor_Project_Carousel() );
    $widgets_manager->register( new \Paint_Elementor_Procedure_Carousel() );
    $widgets_manager->register( new \Paint_Elementor_Color_Code_Carousel() );
    $widgets_manager->register( new \Paint_Elementor_Discover_Grid() );
    $widgets_manager->register( new \Paint_Elementor_Introduce() );
    $widgets_manager->register( new \Paint_Elementor_Image_Carousel() );
}

// Register scripts lib
add_action( 'wp_enqueue_scripts', 'paint_load_script_libs', 10 );
function paint_load_script_libs(): void
{
    $paint_check_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

    if ( $paint_check_elementor == 'builder' ) {
        // owl carousel
        wp_enqueue_style( 'owl.carousel.min', get_theme_file_uri( '/assets/libs/owl.carousel/owl.carousel.min.css' ), array(), null );
        wp_enqueue_script( 'owl.carousel.min', get_theme_file_uri( '/assets/libs/owl.carousel/owl.carousel.min.js' ), array( 'jquery' ), '2.3.4', true );
    }
}

// Register scripts
add_action( 'wp_enqueue_scripts', 'paint_elementor_scripts', 11 );
function paint_elementor_scripts(): void {
	$paint_check_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

	if ( $paint_check_elementor == 'builder' ) {
        wp_enqueue_style( 'paint-elementor-style', get_theme_file_uri( '/extension/elementor-addon/css/elementor-addon.min.css' ), array(), paint_get_version_theme() );

		// script
        wp_enqueue_script( 'paint-elementor-script', get_theme_file_uri(
            '/extension/elementor-addon/js/elementor-addon.min.js' ),
            array( 'jquery', 'swiper' ),
            null,
            true
        );
	}
}

function addZeroBeforeNumber(int $number): int|string {
	if ( $number < 10 ) {
		return '0' . $number;
	}

	return $number;
}

// get all paint color code
function paint_get_all_post_type($post_type): array
{
    $args = [
        'post_type' => $post_type,
        'posts_per_page' => -1,
    ];

    $query = new WP_Query( $args );

    $posts = [];

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $posts[ get_the_ID() ] = get_the_title();
        }
    }

    wp_reset_postdata();

    return $posts;
}