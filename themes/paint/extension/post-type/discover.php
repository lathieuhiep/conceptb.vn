<?php
/*
*---------------------------------------------------------------------
* This file create and contains the template post type oil product
*---------------------------------------------------------------------
*/

add_action('init', 'paint_create_discover', 10);

function paint_create_discover(): void
{

  /* Start post type */
  $labels = array(
    'name' => _x('Khám phá', 'post type general name', 'paint'),
    'singular_name' => _x('Khám phá', 'post type singular name', 'paint'),
    'menu_name' => _x('Khám phá', 'admin menu', 'paint'),
    'name_admin_bar' => _x('Tất cả', 'add new on admin bar', 'paint'),
    'add_new' => _x('Thêm mới', 'Khám phá', 'paint'),
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
    'menu_icon' => 'dashicons-format-gallery',
    'rewrite' => array('slug' => 'kham-pha'),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'thumbnail', 'author', 'excerpt', 'comments'),
  );

  register_post_type('paint_discover', $args);
  /* End post type */

  /* Start taxonomy */
  $taxonomy_labels = array(
    'name' => _x('Danh mục khám phá', 'taxonomy general name', 'paint'),
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
    'labels' => $taxonomy_labels,
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'danh-muc-kham-pha'),
  );

  register_taxonomy('paint_discover_cat', array('paint_discover'), $taxonomy_args);
  /* End taxonomy */
}