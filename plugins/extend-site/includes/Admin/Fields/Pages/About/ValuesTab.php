<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ValuesTab implements FieldTabIF
{
    private const KEY = 'es_about_page_values_tab_';
    private const ITEMS = self::KEY . 'items';

    public static function fields(): array
    {
        return [
            Field::make('complex', self::ITEMS, esc_html__('Danh sách giá trị', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('image', 'icon_image', esc_html__('Ảnh icon', 'extend-site'))
                        ->set_width(25),

                    Field::make('text', 'title', esc_html__('Tiêu đề', 'extend-site'))
                        ->set_width(25),

                    Field::make('textarea', 'description', esc_html__('Mô tả', 'extend-site'))
                        ->set_rows(3)
                        ->set_width(50),
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
            'items' => !empty($items) ? $items : self::default_items(),
        ];
    }

    private static function default_items(): array
    {
        return [
            [
                'icon_image' => '',
                'title' => 'TRÁCH NHIỆM',
                'description' => 'Suy nghĩ thấu đáo, hành động mẫu mực, phù hợp với vị trí, vai trò của mỗi cá nhân',
            ],
            [
                'icon_image' => '',
                'title' => 'CHUYÊN NGHIỆP',
                'description' => 'Học hỏi, rèn giũa kỹ năng, kinh nghiệm và rèn luyện về tác phong, thái độ, cách thức làm việc',
            ],
            [
                'icon_image' => '',
                'title' => 'TẬP TRUNG',
                'description' => 'Dành tối đa thời gian, trí lực, kỹ năng và kinh nghiệm để thực hiện công việc',
            ],
        ];
    }
}
