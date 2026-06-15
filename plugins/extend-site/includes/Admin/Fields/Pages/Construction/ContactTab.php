<?php
namespace ExtendSite\Admin\Fields\Pages\Construction;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;
use ExtendSite\Helpers\ESHelpers;

defined('ABSPATH') || exit;

class ContactTab implements FieldTabIF
{
    private const KEY = 'es_construction_page_contact_tab_';
    private const HEADING = self::KEY . 'heading';
    private const FORM_ID = self::KEY . 'form_id';

    public static function fields(): array
    {
        return [
            Field::make('text', self::HEADING, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value(esc_html__('LIÊN HỆ TƯ VẤN', 'extend-site'))
                ->set_width(50),

            Field::make('select', self::FORM_ID, esc_html__('Chọn Contact Form 7', 'extend-site'))
                ->add_options(ESHelpers::get_form_cf7())
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'heading' => trim((string) carbon_get_post_meta($post_id, self::HEADING)),
            'form_id' => (int) carbon_get_post_meta($post_id, self::FORM_ID),
        ];
    }
}
