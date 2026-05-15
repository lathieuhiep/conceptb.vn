<?php

namespace ExtendSite\PostType;

use ExtendSite\Admin\Fields\ToolFields;

defined('ABSPATH') || exit;

class ToolPostType extends BasePostType
{
    public const SLUG = 'paint_tool';
    public const TAX_CATEGORY = 'paint_tool_cat';
    public const TAX_TAG = 'paint_tool_tag';
    public const SINGULAR = 'Dụng cụ';
    public const PLURAL = 'Dụng cụ';
    public const MENU_NAME = 'Dụng cụ';

    public function __construct(array $args = [])
    {
        parent::__construct($args);

        add_action('cmb2_admin_init', [$this, 'register_fields']);
    }

    protected function register_taxonomies(): void
    {
        $taxonomy_labels = [
            'name' => _x('Danh mục dụng cụ', 'taxonomy general name', 'extend-site'),
            'singular_name' => _x('Danh mục', 'taxonomy singular name', 'extend-site'),
            'search_items' => esc_html__('Tìm kiếm danh mục', 'extend-site'),
            'all_items' => esc_html__('Tất cả danh mục', 'extend-site'),
            'parent_item' => esc_html__('Danh mục cha', 'extend-site'),
            'parent_item_colon' => esc_html__('Danh mục cha:', 'extend-site'),
            'edit_item' => esc_html__('Sửa danh mục', 'extend-site'),
            'update_item' => esc_html__('Cập nhật danh mục', 'extend-site'),
            'add_new_item' => esc_html__('Thêm mới danh mục', 'extend-site'),
            'new_item_name' => esc_html__('Tên danh mục mới', 'extend-site'),
            'menu_name' => esc_html__('Danh mục', 'extend-site'),
        ];

        register_taxonomy(self::TAX_CATEGORY, [self::SLUG], [
            'labels' => $taxonomy_labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'danh-muc-dung-cu'],
        ]);

        $tag_labels = [
            'name' => _x('Thẻ dụng cụ', 'taxonomy general name', 'extend-site'),
            'singular_name' => _x('Thẻ', 'taxonomy singular name', 'extend-site'),
            'search_items' => esc_html__('Tìm Thẻ', 'extend-site'),
            'popular_items' => esc_html__('Thẻ phổ biến', 'extend-site'),
            'all_items' => esc_html__('Tất cả thẻ', 'extend-site'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => esc_html__('Sửa thẻ', 'extend-site'),
            'update_item' => esc_html__('Cập nhập', 'extend-site'),
            'add_new_item' => esc_html__('Thêm thẻ', 'extend-site'),
            'new_item_name' => esc_html__('Tên thẻ mới', 'extend-site'),
            'separate_items_with_commas' => esc_html__('Phân tách bởi dấu phẩy hoặc phím Enter.', 'extend-site'),
            'add_or_remove_items' => esc_html__('Thêm hoặc xoá thẻ', 'extend-site'),
            'choose_from_most_used' => esc_html__('Các thẻ được sử dụng nhiều nhất', 'extend-site'),
            'menu_name' => esc_html__('Thẻ', 'extend-site'),
        ];

        register_taxonomy(self::TAX_TAG, self::SLUG, [
            'hierarchical' => false,
            'labels' => $tag_labels,
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => ['slug' => 'the-dung-cu'],
        ]);
    }

    public function register_ctp(): void
    {
        $labels = [
            'name' => _x('Dụng cụ', 'post type general name', 'extend-site'),
            'singular_name' => _x('Dụng cụ', 'post type singular name', 'extend-site'),
            'menu_name' => _x('Dụng cụ', 'admin menu', 'extend-site'),
            'name_admin_bar' => _x('Tất cả', 'add new on admin bar', 'extend-site'),
            'add_new' => _x('Thêm mới', 'Dụng cụ', 'extend-site'),
            'add_new_item' => esc_html__('Thêm mới', 'extend-site'),
            'edit_item' => esc_html__('Sửa', 'extend-site'),
            'new_item' => esc_html__('Thêm mới', 'extend-site'),
            'view_item' => esc_html__('Xem', 'extend-site'),
            'all_items' => esc_html__('Tất cả', 'extend-site'),
            'search_items' => esc_html__('Tìm kiếm', 'extend-site'),
            'not_found' => esc_html__('Không tìm thấy', 'extend-site'),
            'not_found_in_trash' => esc_html__('Không tìm thấy trong thùng rác', 'extend-site'),
            'parent_item_colon' => '',
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'menu_icon' => 'dashicons-buddicons-topics',
            'rewrite' => ['slug' => 'dung-cu'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => 7,
            'supports' => ['title', 'editor', 'thumbnail', 'author'],
        ];

        register_post_type(self::SLUG, array_replace_recursive($args, $this->args));

        $this->mark_rewrite_flush_needed();
    }

    public function register_fields(): void
    {
        ToolFields::register(self::SLUG);
    }
}
