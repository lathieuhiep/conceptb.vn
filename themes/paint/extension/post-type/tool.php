<?php
/*
*---------------------------------------------------------------------
* This file create and contains the template post type oil product
*---------------------------------------------------------------------
*/

add_action('init', 'paint_create_tool', 10);

function paint_create_tool(): void
{

  /* Start post type */
  $labels = array(
    'name' => _x('Dụng cụ', 'post type general name', 'paint'),
    'singular_name' => _x('Dụng cụ', 'post type singular name', 'paint'),
    'menu_name' => _x('Dụng cụ', 'admin menu', 'paint'),
    'name_admin_bar' => _x('Tất cả', 'add new on admin bar', 'paint'),
    'add_new' => _x('Thêm mới', 'Dụng cụ', 'paint'),
    'add_new_item' => esc_html__('Thêm mới', 'paint'),
    'edit_item' => esc_html__('Sửa', 'paint'),
    'new_item' => esc_html__('Thêm mới', 'paint'),
    'view_item' => esc_html__('Xem', 'paint'),
    'all_items' => esc_html__('Tất cả', 'paint'),
    'search_items' => esc_html__('Tìm kiếm', 'paint'),
    'not_found' => esc_html__('Không tìm thấy', 'paint'),
    'not_found_in_trash' => esc_html__('Không tìm thấy trong thúng rác', 'paint'),
    'parent_item_colon' => ''
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'menu_icon' => 'dashicons-buddicons-topics',
    'rewrite' => array('slug' => 'dung-cu'),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'thumbnail', 'author'),
  );

  register_post_type('paint_tool', $args);
  /* End post type */

  /* Start taxonomy */
  $taxonomy_labels = array(
    'name' => _x('Danh mục dụng cụ', 'taxonomy general name', 'paint'),
    'singular_name' => _x('Danh mục', 'taxonomy singular name', 'paint'),
    'search_items' => __('Tìm kiếm danh mục', 'paint'),
    'all_items' => __('Tất cả danh mục', 'paint'),
    'parent_item' => __('Danh mục cha', 'paint'),
    'parent_item_colon' => __('Danh mục cha:', 'paint'),
    'edit_item' => __('Sửa danh mục', 'paint'),
    'update_item' => __('Cập nhật danh mục', 'paint'),
    'add_new_item' => __('Thêm mới danh mục', 'paint'),
    'new_item_name' => __('Tên danh mục mới', 'paint'),
    'menu_name' => __('Danh mục', 'paint'),
  );

  $taxonomy_args = array(
    'labels' => $taxonomy_labels,
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'danh-muc-dung-cu'),
  );

  register_taxonomy('paint_tool_cat', array('paint_tool'), $taxonomy_args);
  /* End taxonomy */

  /* Start taxonomy tag */
  $label_tag_args = array(
    'name' => _x('Thẻ dụng cụ', 'taxonomy general name', 'paint'),
    'singular_name' => _x('Thẻ', 'taxonomy singular name', 'paint'),
    'search_items' => esc_html__('Tìm Thẻ', 'paint'),
    'popular_items' => esc_html__('Thẻ phổ biến', 'paint'),
    'all_items' => esc_html__('Tất cả thẻ', 'paint'),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => esc_html__('Sửa thẻ', 'paint'),
    'update_item' => esc_html__('Cập nhập', 'paint'),
    'add_new_item' => esc_html__('Thêm thẻ', 'paint'),
    'new_item_name' => esc_html__('Tên thẻ mới', 'paint'),
    'separate_items_with_commas' => esc_html__('Phân tách bởi dấu phẩy hoặc phím Enter.', 'paint'),
    'add_or_remove_items' => esc_html__('Thêm hoặc xoá thẻ', 'paint'),
    'choose_from_most_used' => esc_html__('Các thẻ được sử dụng nhiều nhất', 'paint'),
    'menu_name' => esc_html__('Thẻ', 'paint'),
  );

  register_taxonomy('paint_tool_tag', 'paint_tool', array(
    'hierarchical' => false,
    'labels' => $label_tag_args,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array('slug' => 'the-dung-cu'),
  ));
  /* End taxonomy tag */

}