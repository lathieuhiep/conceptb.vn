<?php

if (!defined('ABSPATH')) {
  exit;
}

// Required: constant
require get_parent_theme_file_path('/includes/constant.php');

// Required: Theme Function
require get_parent_theme_file_path('/includes/theme-function.php');

// Required: Plugin Activation
require get_parent_theme_file_path('/includes/class-tgm-plugin-activation.php');
require get_parent_theme_file_path('/includes/plugin-activation.php');

// Required: options theme
require get_theme_file_path('extension/theme-option/options.php');

// Required: Theme action filter
require get_parent_theme_file_path('/includes/theme-action-filter.php');

// Required: Elementor
if ( did_action( 'elementor/loaded' ) ) :
    require get_parent_theme_file_path( '/extension/elementor-addon/elementor-addon.php' );
endif;

// Require Widgets
require get_parent_theme_file_path( '/includes/Media_Uploader.php' );

foreach (glob(get_parent_theme_file_path('/extension/widgets/*.php')) as $paint_file_widgets) {
  require $paint_file_widgets;
}

// Require Register Sidebar
require get_parent_theme_file_path('/includes/register-sidebar.php');

// Require Theme Scripts
require get_parent_theme_file_path('/includes/theme-scripts.php');

