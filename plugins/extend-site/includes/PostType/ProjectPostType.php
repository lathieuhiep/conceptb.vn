<?php

namespace ExtendSite\PostType;

use ExtendSite\Admin\Fields\ProjectFields;

defined('ABSPATH') || exit;

class ProjectPostType extends BasePostType
{
    public const SLUG = 'paint_project';
    public const TAX_CATEGORY = 'paint_project_cat';
    public const SINGULAR = 'Dự án';
    public const PLURAL = 'Dự án';
    public const MENU_NAME = 'Dự án';

    public function __construct(array $args = [])
    {
        parent::__construct($args);

        add_action('carbon_fields_register_fields', [$this, 'register_fields']);
    }

    protected function register_taxonomies(): void
    {
        $taxonomy_labels = [
            'name' => _x('Danh mục dự án', 'taxonomy general name', 'extend-site'),
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
            'rewrite' => ['slug' => 'danh-muc-du-an'],
        ]);
    }

    public function register_ctp(): void
    {
        $labels = [
            'name' => _x('Dự án', 'post type general name', 'extend-site'),
            'singular_name' => _x('Dự án', 'post type singular name', 'extend-site'),
            'menu_name' => _x('Dự án', 'admin menu', 'extend-site'),
            'name_admin_bar' => _x('Danh sách dự án', 'add new on admin bar', 'extend-site'),
            'add_new' => _x('Thêm mới', 'Dự án', 'extend-site'),
            'add_new_item' => esc_html__('Thêm mới', 'extend-site'),
            'edit_item' => esc_html__('Sửa', 'extend-site'),
            'new_item' => esc_html__('Dự án mới', 'extend-site'),
            'view_item' => esc_html__('Xem dự án', 'extend-site'),
            'all_items' => esc_html__('Danh sách dự án', 'extend-site'),
            'search_items' => esc_html__('Tìm kiếm dự án', 'extend-site'),
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
            'menu_icon' => 'dashicons-portfolio',
            'rewrite' => ['slug' => 'du-an'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 8,
            'supports' => ['title', 'editor', 'thumbnail', 'author', 'excerpt'],
        ];

        register_post_type(self::SLUG, array_replace_recursive($args, $this->args));

        $this->mark_rewrite_flush_needed();
    }

    public function register_fields(): void
    {
        ProjectFields::register(self::SLUG);
    }
}
