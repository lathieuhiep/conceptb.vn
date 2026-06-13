<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class HeroTab implements FieldTabIF
{
    private const KEY = 'es_about_page_hero_tab_';
    private const IMAGE = self::KEY . 'image';

    public static function fields(): array
    {
        return [
            Field::make('image', self::IMAGE, esc_html__('Ảnh nền', 'extend-site'))
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'image' => carbon_get_post_meta($post_id, self::IMAGE),
        ];
    }
}
