<?php

namespace ExtendSite\Admin\Fields;

defined('ABSPATH') || exit;

class ToolCmbFields
{
    public static function register(string $post_type): void
    {
        if (!function_exists('new_cmb2_box')) {
            return;
        }

        $cmb_gallery = new_cmb2_box([
            'id' => 'paint_cmb_tool_option_side',
            'title' => esc_html__('Gallery', 'extend-site'),
            'object_types' => [$post_type],
            'context' => 'side',
            'priority' => 'low',
            'show_names' => true,
        ]);

        $cmb_gallery->add_field([
            'id' => 'paint_cmb_tool_option_side_gallery',
            'type' => 'file_list',
            'options' => [
                'url' => false,
            ],
            'text' => [
                'add_upload_files_text' => esc_html__('Chọn ảnh', 'extend-site'),
            ],
            'query_args' => ['type' => 'image'],
        ]);

        $cmb_specifications = new_cmb2_box([
            'id' => 'paint_cmb_tool_specifications',
            'title' => esc_html__('Thông tin sản phẩm', 'extend-site'),
            'object_types' => [$post_type],
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => true,
        ]);

        $cmb_specifications->add_field([
            'name' => esc_html__('Shopee URL', 'extend-site'),
            'id' => 'paint_cmb_tool_specifications_url',
            'type' => 'text_url',
            'default' => 'https://shopee.vn/',
        ]);

        $cmb_specifications->add_field([
            'name' => esc_html__('Giá', 'extend-site'),
            'id' => 'paint_cmb_tool_specifications_price',
            'type' => 'text',
            'attributes' => [
                'type' => 'number',
                'min' => '1',
            ],
            'column' => [
                'position' => 2,
            ],
            'display_cb' => [self::class, 'display_price'],
        ]);

        $cmb_specifications->add_field([
            'name' => esc_html__('Chất liệu', 'extend-site'),
            'default' => esc_html__('Nhựa dẻo cao cấp', 'extend-site'),
            'id' => 'paint_cmb_tool_specifications_substance',
            'type' => 'text_medium',
        ]);

        $cmb_specifications->add_field([
            'name' => esc_html__('Kích thước dụng cụ', 'extend-site'),
            'default' => '25*15*12',
            'id' => 'paint_cmb_tool_specifications_size',
            'type' => 'text_medium',
        ]);

        $cmb_specifications->add_field([
            'name' => esc_html__('Màu sắc', 'extend-site'),
            'default' => esc_html__('Trắng - Đỏ', 'extend-site'),
            'id' => 'paint_cmb_tool_specifications_color',
            'type' => 'text_medium',
        ]);

        $cmb_specifications->add_field([
            'name' => esc_html__('Trọng lượng', 'extend-site'),
            'default' => esc_html__('0.5kg - 5 lít', 'extend-site'),
            'id' => 'paint_cmb_tool_specifications_weight',
            'type' => 'text_medium',
        ]);
    }

    public static function display_price($field_args, $field): void
    {
        ?>
        <div class="custom-column-display custom-column-display-price <?php echo esc_attr($field->row_classes()); ?>">
            <strong class="price"><?php echo esc_html(number_format((float) $field->escaped_value(), 0, '', '.')); ?></strong>
            <strong class="currency">đ</strong>
        </div>
        <?php
    }
}
