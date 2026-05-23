<?php
namespace ExtendSite\Admin\Fields\Pages\Faq;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class GeneralTab implements FieldTabIF
{
    private const KEY = 'es_faq_page_general_tab_';
    private const TITLE = self::KEY . 'title';
    private const SUBTITLE = self::KEY . 'subtitle';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('FAQs')
                ->set_width(50),

            Field::make('textarea', self::SUBTITLE, esc_html__('Mô tả ngắn', 'extend-site'))
                ->set_default_value('Một thắc mắc các bạn về sản phẩm, kỹ thuật, giá và bảo hành đều được giải đáp tại đây')
                ->set_rows(3)
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'title' => carbon_get_post_meta($post_id, self::TITLE) ?: 'FAQs',
            'subtitle' => carbon_get_post_meta($post_id, self::SUBTITLE),
        ];
    }
}
