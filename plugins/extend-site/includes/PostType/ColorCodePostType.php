<?php

namespace ExtendSite\PostType;

use ExtendSite\Admin\Fields\ColorCodeFields;

defined('ABSPATH') || exit;

class ColorCodePostType extends BasePostType
{
    public const SLUG = 'paint_color_code';
    public const TAX_CATEGORY = 'paint_color_code_cat';
    public const SINGULAR = 'Mã màu sơn';
    public const PLURAL = 'Mã màu sơn';
    public const MENU_NAME = 'Mã màu sơn';

    public function __construct(array $args = [])
    {
        parent::__construct($args);

        add_action('cmb2_admin_init', [$this, 'register_fields']);
    }

    protected function register_taxonomies(): void
    {
        $labels_cat = [
            'name' => _x('Danh mục mã màu', 'taxonomy general name', 'extend-site'),
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

        $taxonomy_args = [
            'labels' => $labels_cat,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'danh-muc-mau-son'],
        ];

        register_taxonomy(self::TAX_CATEGORY, [self::SLUG], $taxonomy_args);
    }

    public function register_ctp(): void
    {
        $labels = [
            'name' => _x('Mã màu sơn', 'post type general name', 'extend-site'),
            'singular_name' => _x('Mã màu sơn', 'post type singular name', 'extend-site'),
            'menu_name' => _x('Mã màu sơn', 'admin menu', 'extend-site'),
            'name_admin_bar' => _x('Danh sách mã màu sơn', 'add new on admin bar', 'extend-site'),
            'add_new' => _x('Thêm mới', 'mã màu sơn', 'extend-site'),
            'add_new_item' => esc_html__('Thêm', 'extend-site'),
            'edit_item' => esc_html__('Sửa', 'extend-site'),
            'new_item' => esc_html__('Mới', 'extend-site'),
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
            'menu_icon' => 'dashicons-color-picker',
            'capability_type' => 'post',
            'rewrite' => ['slug' => 'mau-son'],
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => 6,
            'supports' => ['title', 'thumbnail', 'author'],
        ];

        register_post_type(self::SLUG, array_replace_recursive($args, $this->args));

        $this->mark_rewrite_flush_needed();
    }

    public function register_fields(): void
    {
        ColorCodeFields::register(self::SLUG);
    }
}
