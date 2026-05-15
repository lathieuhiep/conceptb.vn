<?php

namespace ExtendSite\Admin\Fields;

defined('ABSPATH') || exit;

class DiscoverFields
{
    public static function register(string $post_type): void
    {
        if (!function_exists('new_cmb2_box')) {
            return;
        }

        $cmb = new_cmb2_box([
            'id' => 'paint_cmb_discover',
            'title' => esc_html__('Options', 'extend-site'),
            'object_types' => [$post_type],
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true,
        ]);

        $cmb->add_field([
            'id' => 'paint_cmb_discover_color',
            'name' => esc_html__('Mã màu', 'extend-site'),
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => esc_html__('Link mã màu', 'extend-site'),
            'id' => 'paint_cmb_discover_color_url',
            'type' => 'text_url',
            'default' => '#',
        ]);

        $cmb->add_field([
            'id' => 'paint_cmb_discover_classify',
            'name' => esc_html__('Phân loại', 'extend-site'),
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => esc_html__('Dụng cụ thi công', 'extend-site'),
            'id' => 'paint_cmb_discover_construction_tools',
            'type' => 'file_list',
            'query_args' => ['type' => 'image'],
            'text' => [
                'add_upload_files_text' => esc_html__('Thêm ảnh', 'extend-site'),
            ],
        ]);

        $cmb->add_field([
            'name' => esc_html__('Video hướng dẫn', 'extend-site'),
            'desc' => esc_html__('Nhập URL youtube, twitter hoặc instagram.', 'extend-site'),
            'id' => 'paint_cmb_discover_video',
            'type' => 'oembed',
        ]);
    }
}
