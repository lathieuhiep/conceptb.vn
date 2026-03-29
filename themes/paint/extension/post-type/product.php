<?php
/*
*---------------------------------------------------------------------
* This file create and contains the template post type oil product
*---------------------------------------------------------------------
*/

add_action('init', 'paint_create_product', 10);

function paint_create_product(): void
{

  /* Start post type */
  $labels = array(
    'name' => _x('Sản phẩm', 'post type general name', 'paint'),
    'singular_name' => _x('Sản phẩm', 'post type singular name', 'paint'),
    'menu_name' => _x('Sản phẩm', 'admin menu', 'paint'),
    'name_admin_bar' => _x('Tất cả', 'add new on admin bar', 'paint'),
    'add_new' => _x('Thêm mới', 'Sản phẩm', 'paint'),
    'add_new_item' => esc_html__('Thêm mới', 'paint'),
    'edit_item' => esc_html__('Sửa', 'paint'),
    'new_item' => esc_html__('Sản phẩm mới', 'paint'),
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
    'menu_icon' => 'dashicons-cart',
    'rewrite' => array('slug' => 'san-pham'),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'thumbnail', 'author', 'tag'),
  );

  register_post_type('paint_product', $args);
  /* End post type */

  /* Start taxonomy */
  $taxonomy_labels = array(
    'name' => _x('Danh mục sản phẩm', 'taxonomy general name', 'paint'),
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
    'rewrite' => array('slug' => 'danh-muc-san-pham'),
  );

  register_taxonomy('paint_product_cat', array('paint_product'), $taxonomy_args);
  /* End taxonomy */

  /* Start taxonomy tag */
  $tag_labels = array(
    'name' => _x('Thẻ sản phẩm', 'taxonomy general name', 'paint'),
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

  register_taxonomy('paint_product_tag', 'paint_product', array(
    'hierarchical' => false,
    'labels' => $tag_labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array('slug' => 'the-san-pham'),
  ));
  /* End taxonomy tag */

}