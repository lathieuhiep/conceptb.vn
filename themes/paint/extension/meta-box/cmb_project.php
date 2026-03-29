<?php
add_action('cmb2_admin_init', 'paint_cmb_project');

function paint_cmb_project(): void
{
  // position side
  $cmb = new_cmb2_box(array(
    'id' => 'paint_cmb_project',
    'title' => esc_html__('Ảnh dự án', 'paint'),
    'object_types' => array('paint_project',),
    'context' => 'side',
    'priority' => 'low',
    'show_names' => true,
  ));

  $cmb->add_field(array(
    'id' => 'paint_cmb_project_gallery',
    'type' => 'file_list',
    'text' => array(
      'add_upload_files_text' => esc_html__('Thêm ảnh', 'paint')
    ),
  ));

  // position normal
  $cmb_normal =  new_cmb2_box(array(
    'id' => 'paint_cmb_project_normal',
    'title' => esc_html__('Thông tin bổ sung', 'paint'),
    'object_types' => array('paint_project'),
    'context' => 'normal',
    'priority' => 'high',
    'show_names' => true
  ));

  $cmb_normal->add_field( array(
    'name'    => esc_html__('Banner', 'paint'),
    'id'      => 'paint_cmb_project_banner',
    'type'    => 'file',
    'options' => array(
      'url' => false,
    ),
    'text'    => array(
      'add_upload_file_text' => 'Chọn ảnh'
    ),
    'query_args' => array(
       'type' => array(
           'image/jpeg',
           'image/png',
       ),
    ),
    'preview_size' => 'medium',
  ) );

  $cmb_normal->add_field( array(
    'name'    => esc_html__('Loại sơn'),
    'id'      => 'paint_cmb_project_model',
    'type'    => 'text',
  ) );

  $cmb_normal->add_field( array(
    'name'    => esc_html__('Khối lượng'),
    'id'      => 'paint_cmb_project_mass',
    'type'    => 'text',
  ) );

  $cmb_normal->add_field( array(
    'name'    => esc_html__('Thời gian hoàn thành'),
    'id'      => 'paint_cmb_project_completion_time',
    'type'    => 'text',
  ) );

  $cmb_normal->add_field( array(
    'name'    => esc_html__('Loại hình thi công'),
    'id'      => 'paint_cmb_project_construction',
    'type'    => 'text',
  ) );
}