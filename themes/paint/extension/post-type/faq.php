<?php
/*
*---------------------------------------------------------------------
* This file create and contains the template post_type meta elements
*---------------------------------------------------------------------
*/

add_action('init', 'paint_create_post_type_faq', 10);

function paint_create_post_type_faq(): void
{

  /* Start post type template */
  $labels = array(
    'name' => _x('FAQs', 'post type general name', 'paint'),
    'singular_name' => _x('FAQs', 'post type singular name', 'paint'),
    'menu_name' => _x('FAQs', 'admin menu', 'paint'),
    'name_admin_bar' => _x('Danh sách FAQ', 'add new on admin bar', 'paint'),
    'add_new' => _x('Thêm mới', 'FAQ', 'paint'),
    'add_new_item' => esc_html__('Thêm FAQ', 'paint'),
    'edit_item' => esc_html__('Sửa FAQ', 'paint'),
    'new_item' => esc_html__('FAQ mới', 'paint'),
    'view_item' => esc_html__('Xem FAQ', 'paint'),
    'all_items' => esc_html__('Tất cả FAQ', 'paint'),
    'search_items' => esc_html__('Tìm kiếm FAQ', 'paint'),
    'not_found' => esc_html__('Không tìm thấy', 'paint'),
    'not_found_in_trash' => esc_html__('Không tìm thấy trong thùng rác', 'paint'),
    'parent_item_colon' => ''
  );

  $args = array(
    'labels' => $labels,
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'menu_icon' => 'dashicons-format-chat',
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'cau-hoi-thuong-gap'),
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'author'),
  );

  register_post_type('paint_faq', $args);
  /* End post type template */

}