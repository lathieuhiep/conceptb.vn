<?php

namespace ExtendSite\Admin\Fields\Pages\Home;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProductTab implements FieldTabIF
{
    private const
        KEY = 'es_home_page_product_',
        HEADING = self::KEY . 'heading',
        BG_IMAGE = self::KEY . 'bg_image',
        ORDER = self::KEY . 'order',
        ITEMS = self::KEY . 'items';

    // To be implemented in the future.
    public static function fields(): array
    {
        return [
            // section options
            Field::make('text', self::HEADING, esc_html__('Tiêu đề khối', 'extend-site'))
                ->set_default_value(esc_html__('SẢN PHẨM', 'extend-site'))
                ->set_width(50),

            Field::make('image', self::BG_IMAGE, esc_html__('Ảnh nền section', 'extend-site'))
                ->set_width(50),

            Field::make('select', self::ORDER, esc_html__('Thứ tự hiển thị card', 'extend-site'))
                ->set_options([
                    'asc' => esc_html__('Tăng dần (1 → 2 → 3)', 'extend-site'),
                    'desc' => esc_html__('Giảm dần (3 → 2 → 1)', 'extend-site'),
                ])
                ->set_default_value('desc')
                ->set_width(50),

            // items - repeater field
            Field::make('complex', self::ITEMS, esc_html__('Danh sách sản phẩm', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('image', 'icon', esc_html__('Icon tiêu đề', 'extend-site'))
                        ->set_width(20),

                    Field::make('text', 'title', esc_html__('Tên sản phẩm', 'extend-site'))
                        ->set_required(true)
                        ->set_width(40),

                    Field::make('text', 'sub_title', esc_html__('Sub title', 'extend-site'))
                        ->set_width(40),

                    Field::make('image', 'product_image', esc_html__('Ảnh sản phẩm (thùng sơn)', 'extend-site'))
                        ->set_width(33),

                    Field::make('image', 'color_image', esc_html__('Ảnh màu đại diện / bề mặt', 'extend-site'))
                        ->set_width(33),

                    Field::make('image', 'real_image', esc_html__('Ảnh thi công thực tế (ảnh lớn)', 'extend-site'))
                        ->set_width(34),

                    Field::make( 'association', 'color_code', esc_html__('Chọn bảng màu', 'extend-site') )
                        ->set_types( array(
                            array(
                                'type'      => 'post',
                                'post_type' => 'paint_color_code',
                            )
                        ) )
                        ->set_max(1)
                        ->set_width(50),
                ])->set_header_template('
                    <% if (title) { %>
                        <%- title %>
                    <% } %>
                '),
        ];
    }

    // Get Product tab data for frontend usage.
    public static function get_data(int $post_id): array
    {
        $items = carbon_get_post_meta($post_id, self::ITEMS) ?: [];
        $order = carbon_get_post_meta($post_id, self::ORDER) ?: 'desc';

        if ($order === 'desc') {
            $items = array_reverse($items);
        }

        return [
            'heading' => trim((string) carbon_get_post_meta($post_id, self::HEADING)),
            'bg_image' => (int) carbon_get_post_meta($post_id, self::BG_IMAGE),
            'order' => $order,
            'items' => array_values($items),
        ];
    }
}