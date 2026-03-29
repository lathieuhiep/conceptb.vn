<?php

namespace ExtendSite\Admin\Fields\Pages\Home;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;
use ExtendSite\Helpers\ESHelpers;

defined('ABSPATH') || exit;

class AboutTab implements FieldTabIF
{
    private const KEY = 'es_home_page_about_tab_';
    private const HEADING = self::KEY . 'heading';
    private const SUB_HEADING = self::KEY . 'sub_heading';
    private const DESCRIPTION = self::KEY . 'description';
    private const BUTTON_TEXT = self::KEY . 'button_text';
    private const BUTTON_LINK = self::KEY . 'button_link';
    private const IMAGE = self::KEY . 'image';

    /**
     * Define Carbon Fields.
     */
    public static function fields(): array
    {
        return [
            Field::make('text', self::HEADING, esc_html__('Tiêu đề chính', 'extend-site'))
                ->set_default_value(esc_html__('VỀ CHÚNG TÔI', 'extend-site'))
                ->set_width(50),

            Field::make('text', self::SUB_HEADING, esc_html__('Tiêu đề nhỏ', 'extend-site'))
                ->set_default_value(esc_html__('Giới thiệu', 'extend-site'))
                ->set_width(50),

            Field::make('textarea', self::DESCRIPTION, esc_html__('Nội dung mô tả', 'extend-site'))
                ->set_rows(6),

            Field::make('text', self::BUTTON_TEXT, esc_html__('Text nút', 'extend-site'))
                ->set_default_value(esc_html__('Về chúng tôi', 'extend-site'))
                ->set_width(50),

            Field::make('select', self::BUTTON_LINK, esc_html__('Trang liên kết', 'extend-site'))
                ->add_options([ESHelpers::class, 'get_all_page'])
                ->set_width(50),

            Field::make('image', self::IMAGE, esc_html__('Ảnh nền', 'extend-site'))
                ->set_value_type('id')
                ->set_width(50),
        ];
    }

    /**
     * Get Partner tab data for frontend usage.
     */
    public static function get_data(int $post_id): array
    {
        $page_id = (int) carbon_get_post_meta($post_id, self::BUTTON_LINK);

        return [
            'heading'     => trim((string) carbon_get_post_meta($post_id, self::HEADING)),
            'sub_heading'  => trim((string) carbon_get_post_meta($post_id, self::SUB_HEADING)),
            'description' => trim((string) carbon_get_post_meta($post_id, self::DESCRIPTION)),
            'button' => [
                'text' => trim((string) carbon_get_post_meta($post_id, self::BUTTON_TEXT)),
                'url'  => $page_id ? get_permalink($page_id) : '',
            ],
            'image' => (int) carbon_get_post_meta($post_id, self::IMAGE)
        ];
    }
}
