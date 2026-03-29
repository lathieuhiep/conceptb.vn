<?php
/*
*---------------------------------------------------------------------
* This file create and contains the template post_type meta elements
*---------------------------------------------------------------------
*/

add_action('init', 'paint_create_post_type_color_code', 10);

function paint_create_post_type_color_code(): void
{

  /* Start post type template */
  $labels = array(
    'name' => _x('Mã màu sơn', 'post type general name', 'paint'),
    'singular_name' => _x('Mã màu sơn', 'post type singular name', 'paint'),
    'menu_name' => _x('Mã màu sơn', 'admin menu', 'paint'),
    'name_admin_bar' => _x('Danh sách mã màu sơn', 'add new on admin bar', 'paint'),
    'add_new' => _x('Thêm mới', 'mã màu sơn', 'paint'),
    'add_new_item' => esc_html__('Thêm', 'paint'),
    'edit_item' => esc_html__('Sửa', 'paint'),
    'new_item' => esc_html__('Mới', 'paint'),
    'view_item' => esc_html__('Xem', 'paint'),
    'all_items' => esc_html__('Tất cả', 'paint'),
    'search_items' => esc_html__('Tìm kiếm', 'paint'),
    'not_found' => esc_html__('Không tìm thấy', 'paint'),
    'not_found_in_trash' => esc_html__('Không tìm thấy trong thùng rác', 'paint'),
    'parent_item_colon' => ''
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'menu_icon' => 'dashicons-color-picker',
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'mau-son'),
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => 5,
    'supports' => array('title', 'thumbnail', 'author'),
  );

  register_post_type('paint_color_code', $args);
  /* End post type template */

  /* Start taxonomy cat */
  $labels_cat = array(
    'name' => _x('Danh mục mã màu', 'taxonomy general name', 'paint'),
    'singular_name' => _x('Danh mục', 'taxonomy singular name', 'paint'),
    'search_items' => esc_html__('Tìm kiếm danh mục', 'paint'),
    'all_items' => esc_html__('Tất cả danh mục', 'paint'),
    'parent_item' => esc_html__('Danh mục cha', 'paint'),
    'parent_item_colon' => esc_html__('Danh mục cha:', 'paint'),
    'edit_item' => esc_html__('Sửa danh mục', 'paint'),
    'update_item' => esc_html__('Cập nhật danh mục', 'paint'),
    'add_new_item' => esc_html__('Thêm mới danh mục', 'paint'),
    'new_item_name' => esc_html__('Tên danh mục mới', 'paint'),
    'menu_name' => esc_html__('Danh mục', 'paint'),
  );

  $taxonomy_args = array(
    'labels' => $labels_cat,
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'danh-muc-mau-son'),
  );

  register_taxonomy('paint_color_code_cat', array('paint_color_code'), $taxonomy_args);
  /* End taxonomy cat */

}