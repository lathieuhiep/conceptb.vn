<?php
add_action('cmb2_admin_init', 'paint_cmb_tool');

function paint_cmb_tool(): void
{
  $cmb_gallery = new_cmb2_box(array(
    'id' => 'paint_cmb_tool_option_side',
    'title' => esc_html__('Gallery', 'paint'),
    'object_types' => array('paint_tool'),
    'context' => 'side',
    'priority' => 'low',
    'show_names' => true
  ));

  $cmb_gallery->add_field(array(
    'id' => 'paint_cmb_tool_option_side_gallery',
    'type' => 'file_list',
    'options' => array(
      'url' => false,
    ),
    'text' => array(
      'add_upload_files_text' => esc_html__('Chọn ảnh', 'paint')
    ),
    'query_args' => array('type' => 'image'),
  ));

  $cmb_specifications = new_cmb2_box(array(
    'id' => 'paint_cmb_tool_specifications',
    'title' => esc_html__('Thông tin sản phẩm', 'paint'),
    'object_types' => array('paint_tool'),
    'context' => 'normal',
    'priority' => 'low',
    'show_names' => true
  ));

  $cmb_specifications->add_field(array(
    'name' => esc_html__('Shopee URL', 'paint'),
    'id' => 'paint_cmb_tool_specifications_url',
    'type' => 'text_url',
    'default' => 'https://shopee.vn/'
  ));

  $cmb_specifications->add_field(array(
    'name' => esc_html__('Giá', 'paint'),
    'id' => 'paint_cmb_tool_specifications_price',
    'type' => 'text',
    'attributes' => array(
      'type' => 'number',
      'min' => '1',
    ),
    'column' => array(
      'position' => 2
    ),
    'display_cb' => 'paint_display_tool_price',
  ));

  $cmb_specifications->add_field(array(
    'name' => esc_html__('Chất liệu', 'paint'),
    'default' => esc_html__('Nhựa dẻo cao cấp', 'paint'),
    'id' => 'paint_cmb_tool_specifications_substance',
    'type' => 'text_medium'
  ));

  $cmb_specifications->add_field(array(
    'name' => esc_html__('Kích thước dụng cụ', 'paint'),
    'default' => '25*15*12',
    'id' => 'paint_cmb_tool_specifications_size',
    'type' => 'text_medium'
  ));

  $cmb_specifications->add_field(array(
    'name' => esc_html__('Màu sắc', 'paint'),
    'default' => esc_html__('Trắng - Đỏ', 'paint'),
    'id' => 'paint_cmb_tool_specifications_color',
    'type' => 'text_medium'
  ));

  $cmb_specifications->add_field(array(
    'name' => esc_html__('Trọng lượng', 'paint'),
    'default' => esc_html__('0.5kg - 5 lít', 'paint'),
    'id' => 'paint_cmb_tool_specifications_weight',
    'type' => 'text_medium'
  ));
}

// call back format price show column
function paint_display_tool_price($field_args, $field): void
{
  ?>
  <div class="custom-column-display custom-column-display-price <?php echo $field->row_classes(); ?>">
    <strong class="price"><?php echo esc_html(number_format($field->escaped_value(), 0, '', '.')); ?></strong>
    <strong class="currency">đ</strong>
  </div>
  <?php
}