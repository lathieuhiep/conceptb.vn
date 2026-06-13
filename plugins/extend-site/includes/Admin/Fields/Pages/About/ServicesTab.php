<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ServicesTab implements FieldTabIF
{
    private const KEY = 'es_about_page_services_tab_';
    private const TITLE = self::KEY . 'title';
    private const ITEMS = self::KEY . 'items';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('DỊCH VỤ CHÚNG TÔI CUNG CẤP')
                ->set_width(50),

            Field::make('complex', self::ITEMS, esc_html__('Danh sách dịch vụ', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('image', 'image', esc_html__('Ảnh', 'extend-site'))
                        ->set_width(30),

                    Field::make('text', 'title', esc_html__('Tiêu đề', 'extend-site'))
                        ->set_width(30),

                    Field::make('textarea', 'description', esc_html__('Mô tả', 'extend-site'))
                        ->set_rows(3)
                        ->set_width(40),
                ])
                ->set_default_value(self::default_items())
                ->set_header_template('
                    <% if (title) { %>
                        <%- title %>
                    <% } %>
                '),
        ];
    }

    public static function get_data(int $post_id): array
    {
        $items = carbon_get_post_meta($post_id, self::ITEMS);

        return [
            'title' => trim((string)carbon_get_post_meta($post_id, self::TITLE)),
            'items' => !empty($items) ? $items : self::default_items(),
        ];
    }

    private static function default_items(): array
    {
        return [
            [
                'image' => '',
                'title' => 'NGHIÊN CỨU & SẢN XUẤT',
                'description' => 'Được hướng dẫn bởi khát khao nâng tầm kiến trúc nước nhà, chúng tôi muốn hình thành một loại vật liệu độc đáo và bền vững.',
            ],
            [
                'image' => '',
                'title' => 'THI CÔNG TRỌN GÓI',
                'description' => 'Được hướng dẫn bởi khát khao nâng tầm kiến trúc nước nhà, chúng tôi muốn hình thành một loại vật liệu độc đáo và bền vững.',
            ],
            [
                'image' => '',
                'title' => 'PHÂN PHỐI TRỰC TIẾP',
                'description' => 'Được hướng dẫn bởi khát khao nâng tầm kiến trúc nước nhà, chúng tôi muốn hình thành một loại vật liệu độc đáo và bền vững.',
            ],
            [
                'image' => '',
                'title' => 'TƯ VẤN & ĐÀO TẠO KỸ THUẬT',
                'description' => 'Được hướng dẫn bởi khát khao nâng tầm kiến trúc nước nhà, chúng tôi muốn hình thành một loại vật liệu độc đáo và bền vững.',
            ],
        ];
    }
}
