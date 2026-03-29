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

// Required: Post type
require get_parent_theme_file_path('/extension/post-type/product.php');
require get_parent_theme_file_path('/extension/post-type/color-code.php');
require get_parent_theme_file_path('/extension/post-type/tool.php');
require get_parent_theme_file_path('/extension/post-type/project.php');
require get_parent_theme_file_path('/extension/post-type/discover.php');
require get_parent_theme_file_path('/extension/post-type/faq.php');

// Required: CMB2
if (!class_exists('CMB2')) {
  require get_parent_theme_file_path('/extension/meta-box/cmb_post.php');
  require get_parent_theme_file_path('/extension/meta-box/cmb_product.php');
  require get_parent_theme_file_path('/extension/meta-box/cmb_color_code.php');
  require get_parent_theme_file_path('/extension/meta-box/cmb_tool.php');
  require get_parent_theme_file_path('/extension/meta-box/cmb_project.php');
  require get_parent_theme_file_path('/extension/meta-box/cmb_discover.php');

  // add fields custom
  require get_parent_theme_file_path('/extension/meta-box/add-fields/address.php');
  require get_parent_theme_file_path('/extension/meta-box/add-fields/fieldset-color.php');
}

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

