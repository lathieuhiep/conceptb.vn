<?php
namespace ExtendSite\Admin\Fields\Pages\Construction;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;
use ExtendSite\PostType\ToolPostType;

defined('ABSPATH') || exit;

class ToolsTab implements FieldTabIF
{
    private const KEY = 'es_construction_page_tools_tab_';
    private const TITLE = self::KEY . 'title';
    private const RECOMMENDED_TITLE = self::KEY . 'recommended_title';
    private const RECOMMENDED_TOOLS = self::KEY . 'recommended_tools';
    private const OTHER_TITLE = self::KEY . 'other_title';
    private const OTHER_TOOLS = self::KEY . 'other_tools';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề khối', 'extend-site'))
                ->set_default_value('DỤNG CỤ THI CÔNG')
                ->set_width(50),

            Field::make('text', self::RECOMMENDED_TITLE, esc_html__('Tiêu đề dụng cụ khuyến nghị', 'extend-site'))
                ->set_default_value('Dụng cụ khuyến nghị')
                ->set_width(50),

            Field::make('association', self::RECOMMENDED_TOOLS, esc_html__('Chọn dụng cụ khuyến nghị', 'extend-site'))
                ->set_types([
                    [
                        'type' => 'post',
                        'post_type' => ToolPostType::SLUG,
                    ],
                ])
                ->set_width(100),

            Field::make('text', self::OTHER_TITLE, esc_html__('Tiêu đề dụng cụ khác', 'extend-site'))
                ->set_default_value('Dụng cụ khác')
                ->set_width(50),

            Field::make('association', self::OTHER_TOOLS, esc_html__('Chọn dụng cụ khác', 'extend-site'))
                ->set_types([
                    [
                        'type' => 'post',
                        'post_type' => ToolPostType::SLUG,
                    ],
                ])
                ->set_width(100),
        ];
    }

    public static function get_data(int $post_id): array
    {
        $recommended_tools = carbon_get_post_meta($post_id, self::RECOMMENDED_TOOLS) ?: [];
        $other_tools = carbon_get_post_meta($post_id, self::OTHER_TOOLS) ?: [];

        return [
            'title' => trim((string) carbon_get_post_meta($post_id, self::TITLE)),
            'recommended_title' => trim((string) carbon_get_post_meta($post_id, self::RECOMMENDED_TITLE)),
            'recommended_tool_ids' => self::get_association_post_ids($recommended_tools),
            'other_title' => trim((string) carbon_get_post_meta($post_id, self::OTHER_TITLE)),
            'other_tool_ids' => self::get_association_post_ids($other_tools),
        ];
    }

    private static function get_association_post_ids(array $items): array
    {
        $ids = [];

        foreach ($items as $item) {
            if (!empty($item['id'])) {
                $ids[] = (int) $item['id'];
            }
        }

        return array_values(array_unique(array_filter($ids)));
    }
}
