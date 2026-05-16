<?php

namespace ExtendSite\Admin\Fields;

use ExtendSite\Helpers\ESHelpers;

defined('ABSPATH') || exit;

class ProductCmbFields
{
    public static function register(string $post_type): void
    {
        if (!function_exists('new_cmb2_box')) {
            return;
        }

        $cmb_image_hover = new_cmb2_box([
            'id' => 'paint_cmb_product_image_hover',
            'title' => esc_html__('Ảnh phụ', 'extend-site'),
            'object_types' => [$post_type],
            'context' => 'side',
            'priority' => 'low',
            'show_names' => true,
        ]);

        $cmb_image_hover->add_field([
            'id' => 'paint_cmb_product_image_feature_hover',
            'type' => 'file',
            'options' => [
                'url' => false,
            ],
            'text' => [
                'add_upload_file_text' => esc_html__('Đặt ảnh thay đổi', 'extend-site'),
            ],
            'query_args' => [
                'type' => [
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ],
            ],
            'preview_size' => 'large',
            'escape_cb' => false,
            'sanitization_cb' => false,
        ]);

        $cmb_options = new_cmb2_box([
            'id' => 'paint_cmb_options_product',
            'title' => esc_html__('Thông tin bổ sung', 'extend-site'),
            'object_types' => [$post_type],
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true,
        ]);

        $cmb_options->add_field([
            'id' => 'paint_cmb_product_code',
            'name' => esc_html__('Mã sản phẩm', 'extend-site'),
            'type' => 'text',
        ]);

        $cmb_options->add_field([
            'name' => esc_html__('Chọn bảng màu', 'extend-site'),
            'desc' => esc_html__('Chọn danh mục chứa bảng màu, nếu danh mục nhiều hơn 1 bảng màu trở lên sẽ hiển thị dạng kiểu vân. Bảng màu được tạo ở mục "Mã màu sơn"', 'extend-site'),
            'id' => 'paint_cmb_options_product_color',
            'type' => 'select',
            'remove_default' => 'true',
            'options' => self::get_color_code_categories(),
        ]);

        $cmb_options->add_field([
            'name' => esc_html__('Album sản phẩm', 'extend-site'),
            'id' => 'paint_cmb_product_image_gallery',
            'type' => 'file_list',
            'options' => [
                'url' => false,
            ],
            'text' => [
                'add_upload_files_text' => esc_html__('Chọn ảnh', 'extend-site'),
                'remove_image_text' => esc_html__('Xóa ảnh', 'extend-site'),
                'file_text' => esc_html__('Ảnh', 'extend-site'),
            ],
            'query_args' => [
                'type' => [
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ],
            ],
            'preview_size' => 'thumbnail',
            'escape_cb' => false,
            'sanitization_cb' => false,
            'desc' => esc_html__('Ảnh sẽ hiển thị ở chi tiết sản phẩm, nếu không có sẽ thay bằng ảnh đại diện', 'extend-site'),
        ]);

        $gallery_field = $cmb_options->add_field([
            'id' => 'paint_cmb_product_gallery',
            'type' => 'group',
            'description' => esc_html__('Hình ảnh thực tế', 'extend-site'),
            'options' => [
                'group_title' => esc_html__('Ảnh {#}', 'extend-site'),
                'add_button' => esc_html__('Thêm', 'extend-site'),
                'remove_button' => esc_html__('Xoá', 'extend-site'),
                'sortable' => true,
                'closed' => true,
                'remove_confirm' => esc_html__('Bạn thật sự muốn xoá?', 'extend-site'),
            ],
        ]);

        $cmb_options->add_group_field($gallery_field, [
            'name' => esc_html__('Kiểu hiển thị', 'extend-site'),
            'id' => 'style',
            'type' => 'select',
            'default' => 'custom',
            'options' => [
                'normal' => esc_html__('Bình thường', 'extend-site'),
                'full' => esc_html__('Full', 'extend-site'),
            ],
        ]);

        $cmb_options->add_group_field($gallery_field, [
            'name' => esc_html__('Chọn ảnh', 'extend-site'),
            'id' => 'image',
            'type' => 'file',
            'options' => [
                'url' => false,
            ],
            'text' => [
                'add_upload_file_text' => esc_html__('Đặt ảnh thay đổi', 'extend-site'),
            ],
            'query_args' => [
                'type' => [
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ],
            ],
            'preview_size' => 'thumbnail',
        ]);

        $construction_process_field = $cmb_options->add_field([
            'id' => 'paint_cmb_product_construction_process',
            'type' => 'group',
            'description' => esc_html__('Quy trình thi công', 'extend-site'),
            'options' => [
                'group_title' => esc_html__('Bước {#}', 'extend-site'),
                'add_button' => esc_html__('Thêm', 'extend-site'),
                'remove_button' => esc_html__('Xoá', 'extend-site'),
                'sortable' => true,
                'closed' => true,
                'remove_confirm' => esc_html__('Bạn thật sự muốn xoá?', 'extend-site'),
            ],
        ]);

        $cmb_options->add_group_field($construction_process_field, [
            'id' => 'step',
            'name' => esc_html__('STT', 'extend-site'),
            'type' => 'text',
            'default' => esc_html__('Bước', 'extend-site'),
        ]);

        $cmb_options->add_group_field($construction_process_field, [
            'name' => esc_html__('Quy trình thi công', 'extend-site'),
            'id' => 'content',
            'type' => 'wysiwyg',
            'options' => [
                'textarea_rows' => 10,
            ],
        ]);
    }

    private static function get_color_code_categories(): array
    {
        return ESHelpers::get_tax_list_with_count('paint_color_code_cat');
    }
}
