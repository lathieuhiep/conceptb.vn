<?php

namespace ExtendSite\Admin\Fields;

defined('ABSPATH') || exit;

class ColorCodeCmbFields
{
    public static function register(string $post_type): void
    {
        if (!function_exists('new_cmb2_box')) {
            return;
        }

        $cmb = new_cmb2_box([
            'id' => 'paint_cmb_color_code_setting',
            'title' => esc_html__('Thông tin mã màu', 'extend-site'),
            'object_types' => [$post_type],
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true,
        ]);

        $cmb->add_field([
            'name' => esc_html__('Tên hiệu', 'extend-site'),
            'id' => 'paint_cmb_color_code_name',
            'type' => 'text',
        ]);

        $type_standard = $cmb->add_field([
            'id' => 'paint_cmb_color_code_standard',
            'type' => 'group',
            'description' => esc_html__('Kiểu màu bình thường', 'extend-site'),
            'options' => [
                'group_title' => esc_html__('Mã sơn {#}', 'extend-site'),
                'add_button' => esc_html__('Thêm', 'extend-site'),
                'remove_button' => esc_html__('Xóa', 'extend-site'),
                'sortable' => true,
                'closed' => true,
                'remove_confirm' => esc_html__('Bạn thật sự muốn xóa?', 'extend-site'),
            ],
            'classes' => 'group-color-code-standard',
        ]);

        $cmb->add_group_field($type_standard, [
            'name' => esc_html__('Số hiệu', 'extend-site'),
            'id' => 'paint_number',
            'type' => 'text',
        ]);

        $cmb->add_group_field($type_standard, [
            'name' => esc_html__('Ảnh mã màu', 'extend-site'),
            'id' => 'image',
            'type' => 'file',
            'options' => [
                'url' => false,
            ],
            'text' => [
                'add_upload_file_text' => esc_html__('Chọn ảnh', 'extend-site'),
            ],
            'query_args' => [
                'type' => [
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ],
            ],
            'preview_size' => 'medium',
        ]);

        $cmb->add_group_field($type_standard, [
            'name' => esc_html__('Ảnh chính', 'extend-site'),
            'id' => 'featured_image',
            'type' => 'file',
            'options' => [
                'url' => false,
            ],
            'text' => [
                'add_upload_file_text' => esc_html__('Chọn ảnh', 'extend-site'),
            ],
            'query_args' => [
                'type' => [
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ],
            ],
            'preview_size' => 'medium',
        ]);

        $cmb->add_group_field($type_standard, [
            'name' => esc_html__('Mô tả', 'extend-site'),
            'id' => 'describe',
            'type' => 'wysiwyg',
            'options' => [
                'textarea_rows' => 16,
            ],
        ]);

        $cmb->add_group_field($type_standard, [
            'name' => esc_html__('Ghi chú', 'extend-site'),
            'id' => 'note',
            'type' => 'wysiwyg',
            'options' => [
                'textarea_rows' => 16,
            ],
        ]);
    }
}
