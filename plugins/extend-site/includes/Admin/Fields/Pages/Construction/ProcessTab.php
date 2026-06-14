<?php
namespace ExtendSite\Admin\Fields\Pages\Construction;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProcessTab implements FieldTabIF
{
    private const KEY = 'es_construction_page_process_tab_';
    private const TITLE = self::KEY . 'title';
    private const IMAGE = self::KEY . 'image';
    private const VIDEO_URL = self::KEY . 'video_url';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('QUY TRÌNH THI CÔNG')
                ->set_width(50),

            Field::make('image', self::IMAGE, esc_html__('Ảnh video', 'extend-site'))
                ->set_width(50),

            Field::make('text', self::VIDEO_URL, esc_html__('Video URL', 'extend-site'))
                ->set_attribute('type', 'url')
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'title' => carbon_get_post_meta($post_id, self::TITLE),
            'image' => carbon_get_post_meta($post_id, self::IMAGE),
            'video_url' => carbon_get_post_meta($post_id, self::VIDEO_URL),
        ];
    }
}
