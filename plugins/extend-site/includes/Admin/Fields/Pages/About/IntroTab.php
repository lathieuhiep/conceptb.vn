<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class IntroTab implements FieldTabIF
{
    private const KEY = 'es_about_page_intro_tab_';
    private const TITLE = self::KEY . 'title';
    private const SUBTITLE = self::KEY . 'subtitle';
    private const DESCRIPTION = self::KEY . 'description';
    private const IMAGE = self::KEY . 'image';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('Tiên phong Công nghệ sơn đá')
                ->set_width(50),

            Field::make('text', self::SUBTITLE, esc_html__('Tiêu đề phụ', 'extend-site'))
                ->set_default_value('Tinh hoa chất xám Việt cho công trình bền vững')
                ->set_width(50),

            Field::make('rich_text', self::DESCRIPTION, esc_html__('Nội dung mô tả', 'extend-site'))
                ->set_width(50),

            Field::make('image', self::IMAGE, esc_html__('Ảnh minh họa', 'extend-site'))
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'title' => trim((string)carbon_get_post_meta($post_id, self::TITLE)),
            'subtitle' => trim((string)carbon_get_post_meta($post_id, self::SUBTITLE)),
            'description' => carbon_get_post_meta($post_id, self::DESCRIPTION),
            'image' => carbon_get_post_meta($post_id, self::IMAGE),
        ];
    }
}
