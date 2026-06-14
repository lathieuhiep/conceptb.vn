<?php
namespace ExtendSite\Admin\Fields\Pages\Construction;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class HeroTab implements FieldTabIF
{
    private const KEY = 'es_construction_page_hero_tab_';
    private const IMAGE = self::KEY . 'image';

    public static function fields(): array
    {
        return [
            Field::make('image', self::IMAGE, esc_html__('Anh nen', 'extend-site'))
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
