<?php
namespace ExtendSite\Admin\Fields\Pages\Construction;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class WorkflowGalleryTab implements FieldTabIF
{
    private const KEY = 'es_construction_page_workflow_gallery_tab_';
    private const TITLE = self::KEY . 'title';
    private const IMAGES = self::KEY . 'images';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('QUY TRÌNH LÀM VIỆC')
                ->set_width(50),

            Field::make('media_gallery', self::IMAGES, esc_html__('Thư viện ảnh', 'extend-site'))
                ->set_type('image')
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'title' => trim((string) carbon_get_post_meta($post_id, self::TITLE)),
            'images' => carbon_get_post_meta($post_id, self::IMAGES),
        ];
    }
}
