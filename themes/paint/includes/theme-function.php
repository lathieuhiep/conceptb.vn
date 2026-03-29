<?php
// get version theme
function paint_get_version_theme(): string {
    return wp_get_theme()->get( 'Version' );
}

// Empty Option Proxy Class
if (!class_exists('EmptyOptionProxy')) {
    class EmptyOptionProxy {
        public static function __callStatic($name, $args) { return null; }
    }
}

/**
 * Hàm bổ trợ lấy Option Module an toàn
 * * @template T
 * @param class-string<T> $class Class name của Option Module (ví dụ: GeneralOptions::class)
 * @return class-string<T>|class-string<EmptyOptionProxy> Trả về class name của Option Module hoặc EmptyOptionProxy nếu không tồn tại
 */
function paint_opt(string $class): string
{
    return class_exists($class) ? $class : EmptyOptionProxy::class;
}

/**
 * Lấy dữ liệu an toàn từ một Field Tab Class
 * * @template T
 * @param class-string<T> $class_name Namespace đầy đủ của class
 * @param int|null $post_id ID bài viết, mặc định là hiện tại
 * @return array Mảng dữ liệu hoặc mảng rỗng nếu không tồn tại
 */
function paint_get_field_tab_data(string $class_name, int $post_id = null): array
{
    $post_id = $post_id ?: get_the_ID();

    // Kiểm tra class tồn tại VÀ có hàm get_data
    if (class_exists($class_name) && method_exists($class_name, 'get_data')) {
        return $class_name::get_data($post_id);
    }

    return [];
}

// disable gutenberg editor
add_filter("use_block_editor_for_post_type", "disable_gutenberg_editor");
function disable_gutenberg_editor(): bool
{
    return false;
}

// Callback Comment List
function paint_comments($paint_comment, $paint_comment_args, $paint_comment_depth): void
{
    
    if ('div' === $paint_comment_args['style']) :
        
        $paint_comment_tag = 'div';
        $paint_comment_add_below = 'comment';
    
    else :
        
        $paint_comment_tag = 'li';
        $paint_comment_add_below = 'div-comment';
    
    endif;
    
    ?>
    <<?php echo $paint_comment_tag ?><?php comment_class(empty($paint_comment_args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    
    <?php if ('div' != $paint_comment_args['style']) : ?>

    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">

<?php endif; ?>

    <div class="comment-author vcard">
        <?php if ($paint_comment_args['avatar_size'] != 0) {
            echo get_avatar($paint_comment, $paint_comment_args['avatar_size']);
        } ?>

    </div>
    
    <?php if ($paint_comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation">
        <?php esc_html_e('Your comment is awaiting moderation.', 'paint'); ?>
    </em>
<?php endif; ?>

    <div class="comment-meta commentmetadata">
        <div class="comment-meta-box">
             <span class="name">
                <?php comment_author_link(); ?>
            </span>
            <span class="comment-metadata">
                <?php comment_date(); ?>
            </span>
            
            <?php edit_comment_link(esc_html__('Edit ', 'paint')); ?>
            
            <?php comment_reply_link(array_merge($paint_comment_args, array(
              'add_below' => $paint_comment_add_below,
              'depth' => $paint_comment_depth,
              'max_depth' => $paint_comment_args['max_depth']
            ))); ?>

        </div>

        <div class="comment-text-box">
            <?php comment_text(); ?>
        </div>
    </div>
    
    <?php if ('div' != $paint_comment_args['style']) : ?>
    </div>
<?php endif; ?>
    
    <?php
}

// Content Nav
function paint_comment_nav(): void
{
    // Are there comments to navigate through?
    if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        
        ?>
        <nav class="navigation comment-navigation">
            <h2 class="screen-reader-text">
                <?php esc_html_e('Comment navigation', 'paint'); ?>
            </h2>

            <div class="nav-links">
                <?php
                if ($prev_link = get_previous_comments_link(esc_html__('Older Comments', 'paint'))) :
                    printf('<div class="nav-previous">%s</div>', $prev_link);
                endif;
                
                if ($next_link = get_next_comments_link(esc_html__('Newer Comments', 'paint'))) :
                    printf('<div class="nav-next">%s</div>', $next_link);
                endif;
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .comment-navigation -->
    
    <?php
    endif;
}

// Pagination
function paint_pagination(): void
{
    the_posts_pagination(array(
      'type' => 'list',
      'mid_size' => 2,
      'prev_text' => '<i class="fa-solid fa-left-long"></i>',
      'next_text' => '<i class="fa-solid fa-right-long"></i>',
      'screen_reader_text' => '&nbsp;',
    ));
}

// Pagination Nav Query
function paint_paging_nav_query($query): void
{
    $args = array(
      'prev_text' => '<i class="fa-solid fa-left-long"></i>',
      'next_text' => '<i class="fa-solid fa-right-long"></i>',
      'current' => max(1, get_query_var('paged')),
      'total' => $query->max_num_pages,
      'type' => 'list',
    );
    
    $paginate_links = paginate_links($args);
    
    if ($paginate_links) :
        
        ?>
        <nav class="pagination">
            <?php echo $paginate_links; ?>
        </nav>
    
    <?php
    
    endif;
}

// Get col global
function paint_col_use_sidebar($option_sidebar, $active_sidebar): string
{
    
    if ($option_sidebar != 'hide' && is_active_sidebar($active_sidebar)):
        
        if ($option_sidebar == 'left') :
            $class_position_sidebar = ' order-1 order-md-2';
        else:
            $class_position_sidebar = ' order-1';
        endif;
        
        $class_col_content = 'col-12 col-md-8 col-lg-9' . $class_position_sidebar;
    else:
        $class_col_content = 'col-md-12';
    endif;
    
    return $class_col_content;
}

function paint_col_sidebar(): string
{
    return 'col-12 col-md-4 col-lg-3';
}

// Post Meta
function paint_post_meta(): void
{
    ?>

    <div class="site-post-meta">
    <span class="site-post-author">
        <?php esc_html_e('Author:', 'paint'); ?>

        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
            <?php the_author(); ?>
        </a>
    </span>

        <span class="site-post-date">
      <?php esc_html_e('Post date: ', 'paint');
      the_date(); ?>
    </span>

        <span class="site-post-comments">
      <?php
      comments_popup_link('0 ' . esc_html__('Comment', 'paint'), '1 ' . esc_html__('Comment', 'paint'), '% ' . esc_html__('Comments', 'paint'));
      ?>
    </span>
    </div>
    
    <?php
}

// Link Pages
function paint_link_page(): void
{
    
    wp_link_pages(array(
      'before' => '<div class="page-links">' . esc_html__('Pages:', 'paint'),
      'after' => '</div>',
      'link_before' => '<span class="page-number">',
      'link_after' => '</span>'
    ));
    
}

// Comment
function paint_comment_form(): void
{
    if (comments_open() || get_comments_number()) :
        ?>
        <div class="site-comments">
            <?php comments_template('', true); ?>
        </div>
    <?php
    endif;
}

// Get Category Check Box
function paint_check_get_cat($type_taxonomy): array
{
    $cat_check = array();
    $category = get_terms(
      array(
        'taxonomy' => $type_taxonomy,
        'hide_empty' => false
      )
    );
    
    if (!empty($category)):
        foreach ($category as $item) {
            $cat_check[$item->term_id] = $item->name . ' (' . $item->count . ')';
        }
    endif;
    
    return $cat_check;
}

// Get all custom post
function paint_get_post_types($post_type): array
{
    $args = array(
      'post_type' => $post_type,
      'posts_per_page' => -1
    );
    
    $posts = get_posts($args);
    $postsList = array();
    
    if ($posts) {
        foreach ($posts as $post) {
            $postsList[$post->ID] = $post->post_title;
        }
    }
    
    return $postsList;
}

// Share Facebook
function paint_post_share(): void
{
    
    ?>
    <div class="site-post-share">
        <div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-size="small"
             data-lazy="true">
            <a target="_blank"
               href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"
               class="fb-xfbml-parse-ignore">Chia sẻ</a>
        </div>

        <div class="fb-save" data-uri="<?php the_permalink(); ?>" data-size="small" data-lazy="true"></div>
    </div>
    <?php
    
}

// Get Contact Form 7
function paint_get_form_cf7(): array
{
    $options = array();
    
    if (function_exists('wpcf7')) {
        
        $wpcf7_form_list = get_posts(array(
          'post_type' => 'wpcf7_contact_form',
          'numberposts' => -1,
        ));
        
        $options[0] = esc_html__('Select a Contact Form', 'paint');
        
        if (!empty($wpcf7_form_list) && !is_wp_error($wpcf7_form_list)) :
            foreach ($wpcf7_form_list as $item) :
                $options[$item->ID] = $item->post_title;
            endforeach;
        else :
            $options[0] = esc_html__('Create a Form First', 'paint');
        endif;
        
    }
    
    return $options;
}

// action ajax get color code
add_action('wp_ajax_nopriv_paint_get_color_code', 'paint_get_color_code');
add_action('wp_ajax_paint_get_color_code', 'paint_get_color_code');

function paint_get_color_code()
{
    $postId = (int)$_POST['postId'];
    
    $args = array(
      'post_type' => 'paint_color_code',
      'post__in' => array($postId),
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()):
        while ($query->have_posts()): $query->the_post();
            get_template_part('template-parts/product/detail/inc', 'content-color');
        endwhile;
        wp_reset_postdata();
    else:
        esc_html_e('Không có dữ liệu', 'paint');
    endif;
    
    wp_die();
}

// action ajax get color code standard
add_action('wp_ajax_nopriv_paint_get_color_code_standard', 'paint_get_color_code_standard');
add_action('wp_ajax_paint_get_color_code_standard', 'paint_get_color_code_standard');
function paint_get_color_code_standard()
{
    $idColorCode = (int)$_POST['idColorCode'];
    $key = $_POST['key'];

    $color_code_list = get_post_meta($idColorCode, 'paint_cmb_color_code_standard', true);

    if ( $color_code_list ) {
        $itemCode = $color_code_list[$key];
?>
        <div class="box-full-color">
            <?php
            if ( $itemCode ) :
                $image_id = $itemCode['featured_image_id'] ?: $itemCode['image_id'];
            ?>
                <div class="item-full">
                    <figure class="item__thumbnail image-container">
                        <div class="image-box">
                            <?php echo wp_get_attachment_image( $image_id, 'medium_large' ); ?>
                        </div>

                        <div class="zoom-overlay" data-zoom-src="<?php echo esc_url( wp_get_attachment_url( $image_id ) ); ?>"></div>
                    </figure>

                    <div class="info">
                        <div class="info__top">
                            <h4 class="name">
                                <?php echo esc_html( $itemCode['paint_number'] ); ?>
                            </h4>

                            <div class="action-box">
                                <button type="button" class="btn close-full-color">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>

                        <?php if ( $itemCode['describe'] ) : ?>
                            <div class="desc txt-box">
                                <h4 class="txt-box__title">
                                    <?php esc_html_e('Mô tả mã màu:', 'paint'); ?>
                                </h4>

                                <div class="desc__content">
                                    <?php echo wpautop( $itemCode['describe'] ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ( $itemCode['note'] ) : ?>
                            <div class="note txt-box">
                                <h4 class="txt-box__title">
                                    <?php esc_html_e('Lưu ý:', 'paint'); ?>
                                </h4>

                                <div class="note__content">
                                    <?php echo wpautop( $itemCode['note'] ); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p><?php esc_html_e('Thông tin đang cập nhật', 'paint'); ?></p>
            <?php endif; ?>
        </div>
<?php
    }

    wp_die();
}

// action ajax pagination discover
add_action('wp_ajax_nopriv_paint_pagination_discover', 'paint_pagination_discover');
add_action('wp_ajax_paint_pagination_discover', 'paint_pagination_discover');
function paint_pagination_discover()
{
    $keyword = $_POST['keyword'];
    $limit = (int)$_POST['limit'];
    $paged = (int)$_POST['paged'];
    $cat = $_POST['cat'];

    $tax_query = array();
    if (!empty($cat)) {
        $tax_query = array(
          array(
            'taxonomy' => 'paint_discover_cat',
            'field' => 'slug',
            'terms' => $cat
          ),
        );
    }

    $args = array(
      'post_type' => 'paint_discover',
      'ignore_sticky_posts' => 1,
      'posts_per_page' => $limit,
      's' => $keyword,
      'paged' => $paged,
      'tax_query' => $tax_query
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()):
            $query->the_post();
            
            get_template_part('template-parts/discover/inc', 'render-item');
        
        endwhile;
        wp_reset_postdata();
    }
    
    wp_die();
}

// get url template
function paint_get_tpl_url($tpl): ?string
{
    $url = null;
    
    $pages = get_pages(array(
      'meta_key' => '_wp_page_template',
      'meta_value' => $tpl
    ));
    
    if (isset($pages[0])) {
        $url = get_page_link($pages[0]->ID);
    }
    
    return $url;
}

// action login ajax
add_action('wp_ajax_nopriv_paint_login_from', 'paint_login_from');
add_action('wp_ajax_paint_login_from', 'paint_login_from');

function paint_login_from()
{
    global $wpdb;
    
    // First check the nonce, if it fails the function will break
    check_ajax_referer('ajax-login-nonce', 'security');
    
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;
    
    if (is_numeric($info['user_login'])) {
        $phone_number = (int)$info['user_login'];
        $table_extended_users = $wpdb->prefix . 'extended_users';
        $table_users = $wpdb->prefix . 'users';
        
        $result = $wpdb->get_results(
          "SELECT $table_users.user_login FROM $table_extended_users INNER JOIN $table_users ON $table_extended_users.user_id = $table_users.id WHERE phone_number = $phone_number LIMIT 1"
        );
        
        if (!empty($result[0])) {
            $info['user_login'] = $result[0]->user_login;
        }
    }
    
    // login
    $user_signon = wp_signon($info, false);
    
    if (is_wp_error($user_signon)) {
        $result = [
          'loggedin' => false,
          'message' => esc_html__('Tên người dùng hoặc mật khẩu sai!', 'paint')
        ];
        
        wp_send_json_error($result);
    } else {
        $userLogin = get_userdata($user_signon->ID);
        
        // Check if the role you're interested in, is present in the array.
        if (in_array('subscriber', $userLogin->roles, true)) {
            $result = [
              'loggedin' => true,
              'message' => esc_html__('Đăng nhập thành công!', 'paint')
            ];
            
            wp_send_json_success($result);
            
        } else {
            wp_clear_auth_cookie();
            
            $result = [
              'loggedin' => false,
              'message' => esc_html__('Tên người dùng hoặc mật khẩu sai!', 'paint')
            ];
            
            wp_send_json_error($result);
            
            wp_die();
        }
    }
    
    wp_die();
}

// action change password
add_action('wp_ajax_nopriv_paint_change_password', 'paint_change_password');
add_action('wp_ajax_paint_change_password', 'paint_change_password');
function paint_change_password()
{
    // First check the nonce, if it fails the function will break
    check_ajax_referer('changePassword', 'security', false);
    
    //
    global $wpdb, $current_user;
    $currentUserId = $current_user->id;
    
    if (empty($currentUserId)) {
        wp_die();
    }
    
    $errors = new WP_Error();
    
    // get data form convent to arr
    parse_str($_POST['formData'], $formData);
    
    $old_password = $wpdb->_escape($formData['old_password']);
    $password = $wpdb->_escape($formData['password']);
    $passwordConfirm = $wpdb->_escape($formData['password_confirm']);
    
    // check old password
    if (empty($old_password)) {
        $errors->add('old_password', esc_html__('Mật khẩu cũ không được để trống', 'paint'));
    }
    
    if (!empty($old_password) && !wp_check_password($old_password, $current_user->user_pass, $currentUserId)) {
        $errors->add('old_password', esc_html__('Mật khẩu cũ không đúng', 'paint'));
    }
    
    // check validate password
    if (strlen($password) < 8) {
        $errors->add('password', esc_html__('Độ dài tối thiểu của mật khẩu là 8 kí tự', 'paint'));
    }
    
    if (strlen($password) > 32) {
        $errors->add('password', esc_html__('Độ dài tối đa của mật khẩu là 32 kí tự', 'paint'));
    }
    
    if (strcmp($password, $passwordConfirm) !== 0) {
        $errors->add('password_confirm', esc_html__('Mật khẩu không khớp', 'paint'));
    }
    
    if (count($errors->errors) == 0) {
        wp_set_password($password, $currentUserId);
        
        ob_start();
        get_template_part('components/inc', 'popup-changed-password-success');
        $data = ob_get_clean();
        
        wp_send_json_success($data);
    } else {
        wp_send_json_error($errors->errors);
    }
    
    wp_die();
}

// get data user saved
function paint_get_user_saved($user_id, $post_id)
{
    global $wpdb;
    $table = $wpdb->prefix . 'user_saved';
    
    return $wpdb->get_row("SELECT id, user_id, post_id, post_type, status FROM $table WHERE user_id = $user_id AND post_id = $post_id");
}

// action user saved ajax
add_action('wp_ajax_nopriv_paint_user_saved', 'paint_user_saved');
add_action('wp_ajax_paint_user_saved', 'paint_user_saved');
function paint_user_saved()
{
    global $wpdb, $current_user;
    
    $post_id = $_POST['postId'];
    $post = get_post($post_id);
    
    if (empty($post) && empty($currentUserId)) {
        wp_send_json_error();
        wp_die();
    }
    
    // get data user save
    $post_type_arr = ['paint_discover', 'paint_project'];
    $table = $wpdb->prefix . 'user_saved';
    $user_id = $current_user->id;
    $post_type = $post->post_type;
    $status = 1;
    
    if ( !in_array($post_type, $post_type_arr) ) {
        wp_send_json_error();
        wp_die();
    }
    
    $dataUserSave = paint_get_user_saved($user_id, $post_id);
    
    if ( empty( $dataUserSave ) ) {
        $result = $wpdb->insert($table, array(
          'user_id' => $user_id,
          'post_id' => $post_id,
          'post_type' => $post_type
        ));
    } else {
        $idUserSaved = $dataUserSave->id;
        $status = !$dataUserSave->status;
        
        $result = $wpdb->update($table, array(
          'status' => $status
        ), array( 'ID' => $idUserSaved ));
    }
    
    if ($result) {
        $response = [
          'status' => $status
        ];
        
        wp_send_json_success($response);
    } else {
        wp_send_json_error();
    }
    
    wp_die();
}

//
function paint_get_all_user_saved($post_type, $start_page = 1)
{
  global $wpdb, $current_user;
  $user_id = $current_user->id;

  $table = $wpdb->prefix . 'user_saved';
  $per_page = LIMIT_POST_TYPE_USER_SAVED;
  $offset = ($start_page - 1) * LIMIT_POST_TYPE_USER_SAVED;

  $result = $wpdb->get_results(
    "SELECT id, post_id FROM
    $table WHERE user_id = $user_id
    AND post_type = '".$post_type."'
    AND status = 1
    ORDER BY id DESC
    LIMIT $per_page OFFSET $offset",
    ARRAY_A
  );

  if ( $result ) {
    return array_column($result, 'post_id');
  }

  return null;

}

// action get post type user save ajax
add_action('wp_ajax_nopriv_paint_pagination_post_type_user_saved', 'paint_pagination_post_type_user_saved');
add_action('wp_ajax_paint_pagination_post_type_user_saved', 'paint_pagination_post_type_user_saved');
function paint_pagination_post_type_user_saved()
{
  $postType = $_POST['postType'];
  $paged = (int)$_POST['paged'];

  $ids = paint_get_all_user_saved($postType, $paged);

  if ( !empty( $ids ) ) {
    $args = array(
      'post_type' => $postType,
      'post__in' => $ids,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
      while ($query->have_posts()):
        $query->the_post();

        if ( $postType == 'paint_discover' ) {
          get_template_part('components/inc', 'discover-user-saved');
        } else {
          get_template_part('components/inc', 'project-user-saved');
        }

      endwhile;
      wp_reset_postdata();
    }
  }

  wp_die();
}

// check is blog
function paint_is_blog (): bool
{
	return ( is_archive() || is_author() || is_category() || is_home() || is_tag()) && 'post' == get_post_type();
}

// action get tab product detail ajax
add_action('wp_ajax_nopriv_paint_get_tab_product_detail', 'paint_get_tab_product_detail');
add_action('wp_ajax_paint_get_tab_product_detail', 'paint_get_tab_product_detail');
function paint_get_tab_product_detail()
{
  $idTabs = ['gallery-tab', 'product-info-tab', 'product-construction-process-tab'];
  $idTab = $_POST['idTab'];
  $idProduct = $_POST['idProduct'];

  if ( in_array($idTab, $idTabs) ) {
    if ( $idTab == 'gallery-tab' ) {
      get_template_part('template-parts/product/detail/inc', 'product-gallery', array('idProduct' => $idProduct));
    }

    if ( $idTab == 'product-construction-process-tab' ) {
      get_template_part('template-parts/product/detail/inc', 'construction-process', array('idProduct' => $idProduct));
    }
  }

  wp_die();
}

function paint_preg_replace_ony_number($string): string|null
{
    $number = '';

    if (!empty( $string )) {
        $number = preg_replace('/[^0-9]/', '', strip_tags( $string ) );
    }

    return $number;
}