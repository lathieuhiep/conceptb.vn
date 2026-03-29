<?php
// Remove gutenberg widgets
add_filter('use_widgets_block_editor', '__return_false');

/* Better way to add multiple widgets areas */
function paint_widget_registration($name, $id, $description = ''): void {
    register_sidebar( array(
        'name' => $name,
        'id' => $id,
        'description' => $description,
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>'
    ));
}

function paint_multiple_widget_init(): void {
    paint_widget_registration( esc_html__('Sidebar Main', 'paint'), 'paint-sidebar-main' );
    paint_widget_registration( esc_html__('Sidebar Detail Tool', 'paint'), 'paint-sidebar-tool', esc_html__('Display sidebar detail tool.', 'paint') );

    // sidebar footer
    $opt_number_columns = paint_get_option('paint_opt_footer_columns', '4');

    for ( $i = 1; $i <= $opt_number_columns; $i++ ) {
        paint_widget_registration( esc_html__('Sidebar Footer Column ' . $i, 'paint'), 'paint-sidebar-footer-column-' . $i );
    }
}

add_action('widgets_init', 'paint_multiple_widget_init');