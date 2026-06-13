<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class PublicationTab implements FieldTabIF
{
    private const KEY = 'es_about_page_publication_tab_';
    private const TITLE = self::KEY . 'title';
    private const SUBTITLE = self::KEY . 'subtitle';
    private const BACKGROUND_IMAGE = self::KEY . 'background_image';
    private const ITEMS = self::KEY . 'items';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('ẤN PHẨM')
                ->set_width(50),

            Field::make('text', self::SUBTITLE, esc_html__('Tiêu đề phụ', 'extend-site'))
                ->set_default_value('Tham khảo thêm các ấn phẩm năng lực của ConceptB')
                ->set_width(50),

            Field::make('image', self::BACKGROUND_IMAGE, esc_html__('Ảnh nền', 'extend-site'))
                ->set_width(50),

            Field::make('complex', self::ITEMS, esc_html__('Danh sách ấn phẩm', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('image', 'cover_image', esc_html__('Ảnh bìa', 'extend-site'))
                        ->set_width(30),

                    Field::make('text', 'title', esc_html__('Tên ấn phẩm', 'extend-site'))
                        ->set_width(30),

                    Field::make('textarea', 'shortcode', esc_html__('Shortcode DearFlip', 'extend-site'))
                        ->set_rows(2)
                        ->set_width(40),
                ])
                ->set_default_value([
                    [
                        'cover_image' => '',
                        'title' => 'Hồ sơ năng lực',
                        'shortcode' => '',
                    ],
                    [
                        'cover_image' => '',
                        'title' => 'Online catalogue',
                        'shortcode' => '',
                    ],
                ])
                ->set_header_template('
                    <% if (title) { %>
                        <%- title %>
                    <% } %>
                '),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'title' => trim((string)carbon_get_post_meta($post_id, self::TITLE)),
            'subtitle' => trim((string)carbon_get_post_meta($post_id, self::SUBTITLE)),
            'background_image' => carbon_get_post_meta($post_id, self::BACKGROUND_IMAGE),
            'items' => carbon_get_post_meta($post_id, self::ITEMS),
        ];
    }
}
