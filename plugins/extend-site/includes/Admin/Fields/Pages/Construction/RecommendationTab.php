<?php
namespace ExtendSite\Admin\Fields\Pages\Construction;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class RecommendationTab implements FieldTabIF
{
    private const KEY = 'es_construction_page_recommendation_tab_';
    private const BACKGROUND_IMAGE = self::KEY . 'background_image';
    private const PROCESS_CONTENT = self::KEY . 'process_content';
    private const TABLE_CONTENT = self::KEY . 'table_content';
    private const BUTTON_TEXT = self::KEY . 'button_text';
    private const BUTTON_LINK = self::KEY . 'button_link';

    public static function fields(): array
    {
        return [
            Field::make('image', self::BACKGROUND_IMAGE, esc_html__('Ảnh nền', 'extend-site'))
                ->set_width(50),

            Field::make('rich_text', self::PROCESS_CONTENT, esc_html__('Nội dung quy trình', 'extend-site'))
                ->set_width(100),

            Field::make('rich_text', self::TABLE_CONTENT, esc_html__('Nội dung bảng định mức', 'extend-site'))
                ->set_width(100),

            Field::make('text', self::BUTTON_TEXT, esc_html__('Chữ trên nút', 'extend-site'))
                ->set_default_value('Xem chi tiết quy trình')
                ->set_width(50),

            Field::make('text', self::BUTTON_LINK, esc_html__('Link nút', 'extend-site'))
                ->set_attribute('type', 'url')
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'background_image' => carbon_get_post_meta($post_id, self::BACKGROUND_IMAGE),
            'process_content' => carbon_get_post_meta($post_id, self::PROCESS_CONTENT),
            'table_content' => carbon_get_post_meta($post_id, self::TABLE_CONTENT),
            'button_text' => trim((string) carbon_get_post_meta($post_id, self::BUTTON_TEXT)),
            'button_link' => trim((string) carbon_get_post_meta($post_id, self::BUTTON_LINK)),
        ];
    }
}
