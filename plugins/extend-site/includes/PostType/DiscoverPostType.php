<?php

namespace ExtendSite\PostType;

use ExtendSite\Admin\Fields\DiscoverFields;

defined('ABSPATH') || exit;

class DiscoverPostType extends BasePostType
{
    public const SLUG = 'paint_discover';
    public const TAX_CATEGORY = 'paint_discover_cat';
    public const SINGULAR = 'Khám phá';
    public const PLURAL = 'Khám phá';
    public const MENU_NAME = 'Khám phá';

    public function __construct(array $args = [])
    {
        parent::__construct($args);

        add_action('cmb2_admin_init', [$this, 'register_fields']);
    }

    protected function register_taxonomies(): void
    {
        $taxonomy_labels = [
            'name' => _x('Danh mục khám phá', 'taxonomy general name', 'extend-site'),
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
            'rewrite' => ['slug' => 'danh-muc-kham-pha'],
        ]);
    }

    public function register_ctp(): void
    {
        $labels = [
            'name' => _x('Khám phá', 'post type general name', 'extend-site'),
            'singular_name' => _x('Khám phá', 'post type singular name', 'extend-site'),
            'menu_name' => _x('Khám phá', 'admin menu', 'extend-site'),
            'name_admin_bar' => _x('Tất cả', 'add new on admin bar', 'extend-site'),
            'add_new' => _x('Thêm mới', 'Khám phá', 'extend-site'),
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
            'menu_icon' => 'dashicons-format-gallery',
            'rewrite' => ['slug' => 'kham-pha'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => 9,
            'supports' => ['title', 'editor', 'thumbnail', 'author', 'excerpt', 'comments'],
        ];

        register_post_type(self::SLUG, array_replace_recursive($args, $this->args));

        $this->mark_rewrite_flush_needed();
    }

    public function register_fields(): void
    {
        DiscoverFields::register(self::SLUG);
    }
}
