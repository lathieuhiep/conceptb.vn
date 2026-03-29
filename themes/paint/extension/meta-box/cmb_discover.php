<?php
add_action('cmb2_admin_init', 'paint_cmb_discover');

function paint_cmb_discover(): void
{
  $cmb = new_cmb2_box(array(
    'id' => 'paint_cmb_discover',
    'title' => esc_html__('Options', 'paint'),
    'object_types' => array('paint_discover'),
    'context' => 'normal',
    'priority' => 'high',
    'show_names' => true,
  ));

  $cmb->add_field(array(
    'id' => 'paint_cmb_discover_color',
    'name' => esc_html__('Mã màu', 'paint'),
    'type' => 'text',
  ));

  $cmb->add_field( array(
    'name' => esc_html__( 'Link mã màu', 'paint' ),
    'id'   => 'paint_cmb_discover_color_url',
    'type' => 'text_url',
    'default' => '#',
  ) );

  $cmb->add_field(array(
    'id' => 'paint_cmb_discover_classify',
    'name' => esc_html__('Phân loại', 'paint'),
    'type' => 'text',
  ));

  $cmb->add_field(array(
    'name' => esc_html__('Dụng cụ thi công', 'paint'),
    'id' => 'paint_cmb_discover_construction_tools',
    'type' => 'file_list',
    'query_args' => array( 'type' => 'image' ),
    'text' => array(
      'add_upload_files_text' => esc_html__('Thêm ảnh', 'paint')
    ),
  ));

  $cmb->add_field( array(
    'name' =>  esc_html__('Video hướng dẫn', 'paint'),
    'desc' => esc_html__('Nhập URL youtube, twitter hoặc instagram.', 'paint'),
    'id'   => 'paint_cmb_discover_video',
    'type' => 'oembed',
  ) );
}