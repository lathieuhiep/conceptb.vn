<?php

namespace ExtendSite\Admin\Fields\Pages\Home;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ServicesTab implements FieldTabIF
{
    private const KEY = 'es_home_page_services_';
    private const HEADING = self::KEY . 'heading';
    private const ITEMS = self::KEY . 'items';

    // To be implemented in the future.
    public static function fields(): array
    {
        return [
            // Heading
            Field::make('text', self::HEADING, esc_html__('Tiêu đề khối', 'extend-site'))
                ->set_default_value(esc_html__('DỊCH VỤ', 'extend-site'))
                ->set_width(50),

            // Repeater items
            Field::make('complex', self::ITEMS, esc_html__('Danh sách dịch vụ', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('image', 'icon', esc_html__('Icon', 'extend-site'))
                        ->set_required(true)
                        ->set_width(30),

                    Field::make('text', 'title', esc_html__('Tiêu đề', 'extend-site'))
                        ->set_required(true)
                        ->set_width(35),

                    Field::make('textarea', 'desc', esc_html__('Mô tả', 'extend-site'))
                        ->set_rows(3)
                        ->set_width(35),
                ])->set_header_template('
                    <% if (title) { %>
                        <%- title %>
                    <% } %>
                '),
        ];
    }

    // Get Services tab data for frontend usage.
    public static function get_data(int $post_id): array
    {
        return [
            'heading' => trim((string)carbon_get_post_meta($post_id, self::HEADING)),
            'items' => carbon_get_post_meta($post_id, self::ITEMS),
        ];
    }
}