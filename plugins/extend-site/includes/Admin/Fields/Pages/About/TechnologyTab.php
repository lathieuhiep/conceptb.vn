<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class TechnologyTab implements FieldTabIF
{
    private const KEY = 'es_about_page_technology_tab_';
    private const TITLE = self::KEY . 'title';
    private const BACKGROUND_IMAGE = self::KEY . 'background_image';
    private const ITEMS = self::KEY . 'items';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('CÔNG NGHỆ LÕI')
                ->set_width(50),

            Field::make('image', self::BACKGROUND_IMAGE, esc_html__('Ảnh nền', 'extend-site'))
                ->set_width(50),

            Field::make('complex', self::ITEMS, esc_html__('Danh sách công nghệ', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('image', 'image', esc_html__('Ảnh', 'extend-site'))
                        ->set_width(25),

                    Field::make('text', 'label', esc_html__('Nhãn phụ', 'extend-site'))
                        ->set_default_value('Công nghệ')
                        ->set_width(25),

                    Field::make('text', 'title', esc_html__('Tiêu đề', 'extend-site'))
                        ->set_width(25),

                    Field::make('text', 'subtitle', esc_html__('Tiêu đề phụ', 'extend-site'))
                        ->set_width(25),

                    Field::make('textarea', 'description', esc_html__('Mô tả', 'extend-site'))
                        ->set_rows(4),
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
            'background_image' => carbon_get_post_meta($post_id, self::BACKGROUND_IMAGE),
            'items' => !empty($items) ? $items : self::default_items(),
        ];
    }

    private static function default_items(): array
    {
        return [
            [
                'image' => '',
                'label' => 'Công nghệ',
                'title' => 'LOW VOC',
                'subtitle' => 'Volatile Organic Compounds',
                'description' => 'Các thí nghiệm đã chỉ ra rằng, nồng độ VOC trong nhà luôn cao hơn tới 10 lần so với nồng độ VOC ngoài trời, nhà ở thành phố có nồng độ VOC cao hơn, các ngôi nhà kín, ít thông gió cũng là điều kiện làm tăng hàm lượng VOC trong không khí.',
            ],
            [
                'image' => '',
                'label' => 'Công nghệ',
                'title' => 'XANH',
                'subtitle' => 'Volatile Organic Compounds',
                'description' => 'Giải pháp vật liệu hướng đến không gian sống bền vững, thân thiện với môi trường và phù hợp các công trình hiện đại.',
            ],
            [
                'image' => '',
                'label' => 'Công nghệ',
                'title' => 'BỌC HẠT ĐÁ',
                'subtitle' => 'Volatile Organic Compounds',
                'description' => 'Công nghệ bọc hạt đá giúp bề mặt đồng nhất, tăng độ bền và giữ được cảm quan vật liệu tự nhiên cho hệ sơn đá.',
            ],
        ];
    }
}
