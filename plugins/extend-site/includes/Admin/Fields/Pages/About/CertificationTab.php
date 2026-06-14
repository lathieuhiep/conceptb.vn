<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class CertificationTab implements FieldTabIF
{
    private const KEY = 'es_about_page_certification_tab_';
    private const TITLE = self::KEY . 'title';
    private const IMAGES = self::KEY . 'images';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('ISO & CHỨNG NHẬN CHẤT LƯỢNG')
                ->set_width(50),

            Field::make('media_gallery', self::IMAGES, esc_html__('Thư viện ảnh chứng nhận', 'extend-site'))
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        $images = carbon_get_post_meta($post_id, self::IMAGES);

        return [
            'title' => trim((string)carbon_get_post_meta($post_id, self::TITLE)),
            'images' => is_array($images) ? $images : [],
        ];
    }
}
