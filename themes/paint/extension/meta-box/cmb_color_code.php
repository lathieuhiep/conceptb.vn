<?php
add_action('cmb2_admin_init', 'paint_cmb_color_code');

function paint_cmb_color_code(): void
{
    $cmb = new_cmb2_box(array(
        'id' => 'paint_cmb_color_code_setting',
        'title' => esc_html__('Thông tin mã màu', 'paint'),
        'object_types' => array('paint_color_code'),
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true
    ));

    $cmb->add_field(array(
        'name' => esc_html__('Tên hiệu', 'paint'),
        'id' => 'paint_cmb_color_code_name',
        'type' => 'text',
    ));


    // type standard
    $type_standard = $cmb->add_field(array(
        'id' => 'paint_cmb_color_code_standard',
        'type' => 'group',
        'description' => esc_html__('Kiểu màu bình thường', 'paint'),
        'options' => array(
            'group_title' => esc_html__('Mã sơn {#}', 'paint'),
            'add_button' => esc_html__('Thêm', 'paint'),
            'remove_button' => esc_html__('Xoá', 'paint'),
            'sortable' => true,
            'closed' => true,
            'remove_confirm' => esc_html__('Bạn thật sự muốn xoá?', 'paint'),
        ),
        'classes' => 'group-color-code-standard',
    ));

    $cmb->add_group_field($type_standard, array(
        'name' => esc_html__('Số hiệu', 'paint'),
        'id' => 'paint_number',
        'type' => 'text',
    ));

    $cmb->add_group_field($type_standard, array(
        'name' => esc_html__('Ảnh mã màu', 'paint'),
        'id' => 'image',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'text' => array(
            'add_upload_file_text' => esc_html__('Chọn ảnh', 'paint')
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'medium',
    ));

    $cmb->add_group_field($type_standard, array(
        'name' => esc_html__('Ảnh Chính', 'paint'),
        'id' => 'featured_image',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'text' => array(
            'add_upload_file_text' => esc_html__('Chọn ảnh', 'paint')
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'medium',
    ));

    $cmb->add_group_field($type_standard, array(
        'name' => esc_html__('Mô tả', 'paint'),
        'id' => 'describe',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 16,
        )
    ));

    $cmb->add_group_field($type_standard, array(
        'name' => esc_html__('Ghi chú', 'paint'),
        'id' => 'note',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 16,
        )
    ));
}