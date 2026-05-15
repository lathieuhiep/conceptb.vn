<?php

namespace ExtendSite\PostType;

defined('ABSPATH') || exit;

class FaqPostType extends BasePostType
{
    public const SLUG = 'paint_faq';
    public const SINGULAR = 'FAQ';
    public const PLURAL = 'FAQs';
    public const MENU_NAME = 'FAQs';

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
            'rewrite' => ['slug' => 'cau-hoi-thuong-gap'],
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => 10,
            'supports' => ['title', 'editor', 'author'],
        ];

        register_post_type(self::SLUG, array_replace_recursive($args, $this->args));

        $this->mark_rewrite_flush_needed();
    }
}
