<?php

namespace ExtendSite\Admin\Fields;

defined('ABSPATH') || exit;

class ProjectFields
{
    public static function register(string $post_type): void
    {
        if (!function_exists('new_cmb2_box')) {
            return;
        }

        $cmb = new_cmb2_box([
            'id' => 'paint_cmb_project',
            'title' => esc_html__('Ảnh dự án', 'extend-site'),
            'object_types' => [$post_type],
            'context' => 'side',
            'priority' => 'low',
            'show_names' => true,
        ]);

        $cmb->add_field([
            'id' => 'paint_cmb_project_gallery',
            'type' => 'file_list',
            'text' => [
                'add_upload_files_text' => esc_html__('Thêm ảnh', 'extend-site'),
            ],
        ]);

        $cmb_normal = new_cmb2_box([
            'id' => 'paint_cmb_project_normal',
            'title' => esc_html__('Thông tin bổ sung', 'extend-site'),
            'object_types' => [$post_type],
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true,
        ]);

        $cmb_normal->add_field([
            'name' => esc_html__('Banner', 'extend-site'),
            'id' => 'paint_cmb_project_banner',
            'type' => 'file',
            'options' => [
                'url' => false,
            ],
            'text' => [
                'add_upload_file_text' => esc_html__('Chọn ảnh', 'extend-site'),
            ],
            'query_args' => [
                'type' => [
                    'image/jpeg',
                    'image/png',
                ],
            ],
            'preview_size' => 'medium',
        ]);

        $cmb_normal->add_field([
            'name' => esc_html__('Loại sơn', 'extend-site'),
            'id' => 'paint_cmb_project_model',
            'type' => 'text',
        ]);

        $cmb_normal->add_field([
            'name' => esc_html__('Khối lượng', 'extend-site'),
            'id' => 'paint_cmb_project_mass',
            'type' => 'text',
        ]);

        $cmb_normal->add_field([
            'name' => esc_html__('Thời gian hoàn thành', 'extend-site'),
            'id' => 'paint_cmb_project_completion_time',
            'type' => 'text',
        ]);

        $cmb_normal->add_field([
            'name' => esc_html__('Loại hình thi công', 'extend-site'),
            'id' => 'paint_cmb_project_construction',
            'type' => 'text',
        ]);
    }
}
