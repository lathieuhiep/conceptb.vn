<?php

namespace ExtendSite\PostType;

defined('ABSPATH') || exit;

class FaqPostType extends BasePostType
{
    public const SLUG = 'paint_faq';
    public const TAX_CATEGORY = 'paint_faq_cat';
    public const SINGULAR = 'FAQ';
    public const PLURAL = 'FAQs';
    public const MENU_NAME = 'FAQs';

    protected function register_taxonomies(): void
    {
        $taxonomy_labels = [
            'name' => _x('Danh mục FAQ', 'taxonomy general name', 'extend-site'),
            'singular_name' => _x('Danh mục FAQ', 'taxonomy singular name', 'extend-site'),
            'search_items' => esc_html__('Tìm kiếm danh mục', 'extend-site'),
            'all_items' => esc_html__('Tất cả danh mục', 'extend-site'),
            'parent_item' => esc_html__('Danh mục cha', 'extend-site'),
            'parent_item_colon' => esc_html__('Danh mục cha:', 'extend-site'),
            'edit_item' => esc_html__('Sửa danh mục', 'extend-site'),
            'update_item' => esc_html__('Cập nhật danh mục', 'extend-site'),
            'add_new_item' => esc_html__('Thêm mới danh mục', 'extend-site'),
            'new_item_name' => esc_html__('Tên danh mục mới', 'extend-site'),
            'menu_name' => esc_html__('Danh mục FAQ', 'extend-site'),
        ];

        register_taxonomy(self::TAX_CATEGORY, [self::SLUG], [
            'labels' => $taxonomy_labels,
            'hierarchical' => true,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => false,
        ]);
    }

    public function register_ctp(): void
    {
        $labels = [
            'name' => _x('FAQs', 'post type general name', 'extend-site'),
            'singular_name' => _x('FAQs', 'post type singular name', 'extend-site'),
            'menu_name' => _x('FAQs', 'admin menu', 'extend-site'),
            'name_admin_bar' => _x('Danh sách FAQ', 'add new on admin bar', 'extend-site'),
            'add_new' => _x('Thêm mới', 'FAQ', 'extend-site'),
            'add_new_item' => esc_html__('Thêm FAQ', 'extend-site'),
            'edit_item' => esc_html__('Sửa FAQ', 'extend-site'),
            'new_item' => esc_html__('FAQ mới', 'extend-site'),
            'view_item' => esc_html__('Xem FAQ', 'extend-site'),
            'all_items' => esc_html__('Tất cả FAQ', 'extend-site'),
            'search_items' => esc_html__('Tìm kiếm FAQ', 'extend-site'),
            'not_found' => esc_html__('Không tìm thấy', 'extend-site'),
            'not_found_in_trash' => esc_html__('Không tìm thấy trong thùng rác', 'extend-site'),
            'parent_item_colon' => '',
        ];

        $args = [
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'menu_icon' => 'dashicons-format-chat',
            'capability_type' => 'post',
            'rewrite' => false,
            'has_archive' => false,
            'hierarchical' => true,
            'menu_position' => 10,
            'supports' => ['title', 'editor', 'author'],
            'taxonomies' => [self::TAX_CATEGORY],
        ];

        register_post_type(self::SLUG, array_replace_recursive($args, $this->args));

        $this->mark_rewrite_flush_needed();
    }
}
