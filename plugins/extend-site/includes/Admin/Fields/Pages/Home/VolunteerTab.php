<?php

namespace ExtendSite\Admin\Fields\Pages\Home;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class VolunteerTab implements FieldTabIF
{
    private const KEY = 'es_home_page_volunteer_tab_';
    private const TITLE = self::KEY . 'title';
    private const DESCRIPTION = self::KEY . 'description';
    private const GALLERY = self::KEY . 'gallery';

    /**
     * Define Carbon Fields for Project tab.
     */
    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề ', 'extend-site'))
                ->set_default_value('Thiện nguyện'),

            Field::make('textarea', self::DESCRIPTION, esc_html__('Mô tả', 'extend-site'))
                ->set_rows(3),

            Field::make( 'media_gallery', self::GALLERY, esc_html__('Ảnh', 'extend-site') )
                ->set_type( array( 'image' ) ),
        ];
    }

    /**
     * Get Project tab data for frontend usage.
     */
    public static function get_data(int $post_id): array
    {
        return [
            'title' => carbon_get_post_meta($post_id, self::TITLE),
            'description' => carbon_get_post_meta($post_id, self::DESCRIPTION),
            'gallery' => carbon_get_post_meta($post_id, self::GALLERY),
        ];
    }
}