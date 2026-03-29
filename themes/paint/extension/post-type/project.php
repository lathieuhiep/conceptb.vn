<?php
/*
*---------------------------------------------------------------------
* This file create and contains the template post type oil product
*---------------------------------------------------------------------
*/

add_action('init', 'paint_create_project', 10);

function paint_create_project()
{

  /* Start post type */
  $labels = array(
    'name' => _x('Dự án', 'post type general name', 'paint'),
    'singular_name' => _x('Dự án', 'post type singular name', 'paint'),
    'menu_name' => _x('Dự án', 'admin menu', 'paint'),
    'name_admin_bar' => _x('Danh sách dự án', 'add new on admin bar', 'paint'),
    'add_new' => _x('Thêm mới', 'Dự án', 'paint'),
    'add_new_item' => esc_html__('Thêm mới', 'paint'),
    'edit_item' => esc_html__('Sửa', 'paint'),
    'new_item' => esc_html__('Dự án mới', 'paint'),
    'view_item' => esc_html__('Xem dự án', 'paint'),
    'all_items' => esc_html__('Danh sách dự án', 'paint'),
    'search_items' => esc_html__('Tìm kiếm dự án', 'paint'),
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
    'menu_icon' => 'dashicons-portfolio',
    'rewrite' => array('slug' => 'du-an'),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'thumbnail', 'author', 'excerpt'),
  );

  register_post_type('paint_project', $args);
  /* End post type */

  /* Start taxonomy */
  $taxonomy_labels = array(
    'name' => _x('Danh mục dự án', 'taxonomy general name', 'paint'),
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
    'rewrite' => array('slug' => 'danh-muc-du-an'),
  );

  register_taxonomy('paint_project_cat', array('paint_project'), $taxonomy_args);
  /* End taxonomy */

}