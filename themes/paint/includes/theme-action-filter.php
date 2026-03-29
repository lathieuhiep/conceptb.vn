<?php
// Setup Theme
add_action('after_setup_theme', 'paint_setup');
function paint_setup(): void
{
  // Set the content width based on the theme's design and stylesheet.
  global $content_width;

  if (!isset($content_width)) {
    $content_width = 900;
  }

  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   */
  load_theme_textdomain('paint', get_parent_theme_file_path('/languages'));

  /**
   * Set up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support post thumbnails.
   *
   */
  add_theme_support('custom-header');

  add_theme_support('custom-background');

  //Enable support for Post Thumbnails
  add_theme_support('post-thumbnails');

  // Add RSS feed links to <head> for posts and comments.
  add_theme_support('automatic-feed-links');

  // This theme uses wp_nav_menu() in two locations.
  register_nav_menus(
    array(
      'primary' => esc_html__('Primary Menu', 'paint'),
      'footer-menu' => esc_html__('Footer Menu', 'paint'),
    )
  );

  // add theme support title-tag
  add_theme_support('title-tag');
}

// Walker for the main menu
add_filter('walker_nav_menu_start_el', 'paint_add_arrow', 10, 4);
function paint_add_arrow($output, $item, $depth, $args)
{
  if ('primary' == $args->theme_location && $depth >= 0) {
    if (in_array("menu-item-has-children", $item->classes)) {
      $output .= '<span class="sub-menu-toggle"></span>';
    }
  }

  return $output;
}

// add favicon
add_action('wp_head', 'paint_get_favicon', 1);
function paint_get_favicon(): void
{
  $opt_favicon = paint_get_option('general_opt_favicon', '');

  if (empty($opt_favicon['url'])) {
    $favicon = get_theme_file_uri('/assets/images/favicon.png');
  } else {
    $favicon = $opt_favicon['url'];
  }

  echo '<link rel="shortcut icon" href="' . esc_url($favicon) . '" type="image/x-icon" sizes="16x16" />';
}

// Sanitize Pagination
add_action('navigation_markup_template', 'paint_sanitize_pagination');
function paint_sanitize_pagination($paint_content): string
{
  // Remove role attribute
  $paint_content = str_replace('role="navigation"', '', $paint_content);

  // Remove h2 tag
  return preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $paint_content);
}

// add meta opengraph
add_action('wp_head', 'paint_opengraph', 5);
function paint_opengraph(): void
{
  global $post;

  if (is_singular('post') || is_singular('paint_discover')) :

    if (has_post_thumbnail($post->ID)) :
      $img_src = get_the_post_thumbnail_url(get_the_ID(), 'full');
    else :
      $img_src = get_theme_file_uri('/images/no-image.png');
    endif;

    $excerpt = $post->post_excerpt;

    if ($excerpt) :
      $excerpt = strip_tags($post->post_excerpt);
      $excerpt = str_replace("", "'", $excerpt);
    else :
      $excerpt = get_bloginfo('description');
    endif;

    ?>
    <meta property="og:url" content="<?php the_permalink(); ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php the_title(); ?>"/>
    <meta property="og:description" content="<?php echo esc_attr($excerpt); ?>"/>
    <meta property="og:image" content="<?php echo esc_url($img_src); ?>"/>
  <?php
  endif;
}

// add scrip footer
add_action('wp_footer', 'paint_add_scrip_footer');
function paint_add_scrip_footer(): void
{
  // SDK facebook
  if (is_singular('post') || is_singular('paint_discover')) :
    $facebookAppId = paint_get_option('social_sharing_facebook_app_id');
    ?>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
            src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0&appId=<?php echo esc_attr($facebookAppId); ?>&autoLogAppEvents=1"
            nonce="bsmdVU7y"></script>
  <?php
  endif;
}

// Custom Search Post
add_action('pre_get_posts', 'paint_include_custom_post_types_in_search_results');
function paint_include_custom_post_types_in_search_results($query): void
{
  if ($query->is_main_query() && $query->is_search() && !is_admin()) {
    $query->set('post_type', array('post'));
  }
}

// add column products
add_filter('manage_paint_product_posts_columns', 'paint_custom_product_columns');
function paint_custom_product_columns($columns)
{
  $columns['taxonomy-paint_product_tag'] = esc_html__('Thẻ', 'paint');

  return $columns;
}

// order column products
//add_filter('manage_paint_product_posts_columns', 'paint_order_product_columns');
function paint_order_product_columns($columns): array
{
  return array(
    'title' => $columns['title'],
    'author' => $columns['author'],
    'taxonomy-paint_product_cat' => $columns['taxonomy-paint_product_cat'],
    'taxonomy-paint_product_tag' => $columns['taxonomy-paint_product_tag'],
    'date' => $columns['date']
  );
}

// add column post type tool
add_filter('manage_paint_tool_posts_columns', 'paint_custom_tool_columns');
function paint_custom_tool_columns($columns)
{
  $columns['taxonomy-paint_tool_tag'] = esc_html__('Thẻ', 'paint');

  return $columns;
}

// order column post type tool
//add_filter('manage_paint_tool_posts_columns', 'paint_order_tool_columns');
function paint_order_tool_columns($columns): array
{
  return array(
    'title' => $columns['title'],
    'author' => $columns['author'],
    'taxonomy-paint_tool_cat' => $columns['taxonomy-paint_tool_cat'],
    'taxonomy-paint_tool_tag' => $columns['taxonomy-paint_tool_tag'],
    'date' => $columns['date']
  );
}

// Set limit custom post type
define('posts_per_page_discover', paint_get_option('discover_opt_limit', 12));

add_action('pre_get_posts', 'paint_set_query_custom_post_type');
function paint_set_query_custom_post_type($query): void
{
  if (!is_admin() && $query->is_main_query()) {
    // custom query page_for_posts
    if ( get_option( 'page_for_posts' )  ) {
      $query->set( 'ignore_sticky_posts', true );
    }

    // custom query archive post type discover
    if (is_post_type_archive('paint_discover')) {
      $query->set('posts_per_page', posts_per_page_discover);
    }

    // custom query archive & cat post type project
    if (is_post_type_archive('paint_project')) {
      $opt_project_limit = paint_get_option('template_project_opt_limit', 12);
      $opt_project_order_by = paint_get_option('template_project_opt_order_by', 'id');
      $opt_project_order = paint_get_option('template_project_opt_order', 'ASC');

      $query->set('posts_per_page', $opt_project_limit);
      $query->set('orderby', $opt_project_order_by);
      $query->set('order', $opt_project_order);
    }

    //  custom query archive & cat post type product
    if (is_post_type_archive('paint_product')) {
      $opt_product_limit = paint_get_option('paint_opt_product_cat_limit', 8);

      $query->set('posts_per_page', $opt_product_limit);
    }

  }
}

// load template search custom post type
add_filter('template_include', 'paint_template_search_post_type');
function paint_template_search_post_type($template)
{
  global $wp_query;
  $post_type = !empty($_GET['post_type']) ? $_GET['post_type'] : 'post';

  if ($wp_query->is_search && $post_type == 'paint_discover') {
    return locate_template('search-paint_discover.php');
  }

  if ($wp_query->is_search && $post_type == 'paint_project') {
    return locate_template('search-paint_project.php');
  }

  return $template;
}

// remove prefix title archive
add_filter('get_the_archive_title', 'paint_child_filter_archive_title');
function paint_child_filter_archive_title()
{
  if (is_post_type_archive()) {
    return post_type_archive_title('', false);
  }
}

//
add_action('after_setup_theme', 'paint_remove_admin_bar');
function paint_remove_admin_bar(): void
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

/**
 * Chuyển đổi thẻ link phông chữ sang chuẩn Preload/Async
 */
function paint_partner_async_google_fonts( $tag, $handle, $src ) {
    // Chỉ áp dụng cho handle 'google-font' đã đăng ký
    if ( 'google-font' === $handle ) {
        $tag = '<link rel="preload" as="style" href="' . esc_url( $src ) . '" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
        $tag .= '<noscript><link rel="stylesheet" href="' . esc_url( $src ) . '"></noscript>';
    }
    return $tag;
}
add_filter( 'style_loader_tag', 'paint_partner_async_google_fonts', 10, 3 );


// Add description to menu items
function my_theme_nav_description( $item_output, $item, $depth, $args ) {
    // 1. Lấy tiêu đề gốc (bao gồm cả link_before/after nếu có)
    $title = $args->link_before . $item->title . $args->link_after;

    // 2. Tạo nội dung mới: Bọc tiêu đề vào span
    $new_content = '<span class="menu-title d-block">' . $title . '</span>';

    // 3. Nếu có mô tả, thêm span mô tả ngay phía sau
    if ( ! empty( $item->description ) ) {
        $new_content .= '<span class="menu-desc d-block">' . $item->description . '</span>';
    }

    // 4. Thay thế lại vào output
    $item_output = str_replace( $title, $new_content, $item_output );

    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'my_theme_nav_description', 10, 4 );