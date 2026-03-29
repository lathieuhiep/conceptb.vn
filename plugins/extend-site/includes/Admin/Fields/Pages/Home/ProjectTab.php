<?php

namespace ExtendSite\Admin\Fields\Pages\Home;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProjectTab implements FieldTabIF
{
    private const KEY = 'es_home_page_project_tab_';
    private const TITLE = self::KEY . 'title';
    private const DESCRIPTION = self::KEY . 'description';
    private const BUTTON_TEXT = self::KEY . 'button_text';
    private const BUTTON_LINK = self::KEY . 'button_link';
    private const ITEMS = self::KEY . 'items';

    /**
     * Define Carbon Fields for Project tab.
     */
    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề section', 'extend-site'))
                ->set_default_value('DỰ ÁN')
                ->set_width(50),

            Field::make('textarea', self::DESCRIPTION, esc_html__('Mô tả section', 'extend-site'))
                ->set_rows(3)
                ->set_width(50),

            Field::make('text', self::BUTTON_TEXT, esc_html__('Chữ trên nút', 'extend-site'))
                ->set_default_value('Xem thêm công trình')
                ->set_width(50),

            Field::make('text', self::BUTTON_LINK, esc_html__('Link nút', 'extend-site'))
                ->set_attribute('type', 'url')
                ->set_default_value('https://example.com')
                ->set_width(50),

            Field::make('complex', self::ITEMS, esc_html__('Danh sách dự án', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->setup_labels([
                    'plural_name' => esc_html__('Dự án', 'extend-site'),
                    'singular_name' => esc_html__('Dự án', 'extend-site'),
                ])
                ->add_fields([
                    Field::make('image', 'image', esc_html__('Ảnh dự án', 'extend-site'))
                        ->set_value_type('url')
                        ->set_width(50),

                    Field::make('text', 'name', esc_html__('Tên dự án', 'extend-site'))
                        ->set_width(50),

                    Field::make('text', 'subtitle', esc_html__('Mô tả ngắn', 'extend-site'))
                        ->set_width(50),

                    Field::make('text', 'scale', esc_html__('Quy mô (m²)', 'extend-site'))
                        ->set_attribute('type', 'number')
                        ->set_attribute('min', 0)
                        ->set_attribute('placeholder', 'VD: 20000')
                        ->set_width(50),
                ])->set_header_template('
                    <% if (name) { %>
                        <%- name %>
                    <% } %>
                '),
        ];
    }

    /**
     * Get Project tab data for frontend usage.
     */
    public static function get_data(int $post_id): array
    {
        $raw_items = carbon_get_post_meta($post_id, self::ITEMS);

        $items = array_map(function ($item) {
            return [
                'image' => $item['image'] ?? '',
                'name' => $item['name'] ?? '',
                'subtitle' => $item['subtitle'] ?? '',
                'scale' => $item['scale']
                    ? number_format((int)$item['scale'], 0, ',') . ' m²'
                    : '',
            ];
        }, (array)$raw_items);

        return [
            'title' => carbon_get_post_meta($post_id, self::TITLE),
            'description' => carbon_get_post_meta($post_id, self::DESCRIPTION),
            'button' => [
                'text' => carbon_get_post_meta($post_id, self::BUTTON_TEXT),
                'link' => carbon_get_post_meta($post_id, self::BUTTON_LINK),
            ],
            'items' => $items,
        ];
    }
}