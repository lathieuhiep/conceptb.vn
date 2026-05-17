<?php

namespace ExtendSite\Admin\Fields\Product;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProductConstructionTab implements FieldTabIF
{
    public const CONSTRUCTION_OVERVIEW = 'es_product_construction_overview';
    public const CONSTRUCTION_PROCESS = 'es_product_construction_process';

    private const CMB_CONSTRUCTION_PROCESS = 'paint_cmb_product_construction_process';
    private const LAYOUT_CONTENT = 'content';
    private const LAYOUT_CARDS = 'cards';
    private const LAYOUT_IMAGE_COLUMNS = 'image_columns';

    public static function fields(): array
    {
        return [
            Field::make('rich_text', self::CONSTRUCTION_OVERVIEW, esc_html__('Nội dung tổng quan', 'extend-site')),

            Field::make('complex', self::CONSTRUCTION_PROCESS, esc_html__('Quy trình thi công', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->set_collapsed(true)
                ->add_fields('_', esc_html__('Bước', 'extend-site'), [
                    Field::make('text', 'title', esc_html__('Tiêu đề bước', 'extend-site'))
                        ->set_width(50),
                    Field::make('text', 'subtitle', esc_html__('Mô tả ngắn', 'extend-site'))
                        ->set_width(50),
                    Field::make('select', 'layout', esc_html__('Kiểu hiển thị', 'extend-site'))
                        ->add_options([
                            self::LAYOUT_CONTENT => esc_html__('Nội dung thường', 'extend-site'),
                            self::LAYOUT_CARDS => esc_html__('Danh sách thẻ ảnh', 'extend-site'),
                            self::LAYOUT_IMAGE_COLUMNS => esc_html__('Ảnh + bảng cột', 'extend-site'),
                        ])
                        ->set_help_text(esc_html__('Chọn kiểu nhập nội dung cho phần mở rộng của bước này.', 'extend-site'))
                        ->set_default_value(self::LAYOUT_CONTENT),
                    Field::make('rich_text', 'content', esc_html__('Nội dung', 'extend-site'))
                        ->set_conditional_logic([
                            [
                                'field' => 'layout',
                                'value' => self::LAYOUT_CONTENT,
                            ],
                        ]),
                    Field::make('complex', 'cards', esc_html__('Danh sách thẻ', 'extend-site'))
                        ->set_layout('tabbed-vertical')
                        ->set_collapsed(true)
                        ->add_fields('_', esc_html__('Thẻ', 'extend-site'), [
                            Field::make('image', 'image', esc_html__('Ảnh', 'extend-site')),
                            Field::make('text', 'title', esc_html__('Tiêu đề', 'extend-site')),
                            Field::make('rich_text', 'content', esc_html__('Nội dung', 'extend-site')),
                        ])
                        ->set_header_template('<%- title ? title : "' . esc_html__('Thẻ', 'extend-site') . ' " + ($_index + 1) %>')
                        ->set_conditional_logic([
                            [
                                'field' => 'layout',
                                'value' => self::LAYOUT_CARDS,
                            ],
                        ]),
                    Field::make('image', 'image', esc_html__('Ảnh minh họa bên trái', 'extend-site'))
                        ->set_help_text(esc_html__('Ảnh hiển thị ở cột trái của bố cục Ảnh + bảng cột.', 'extend-site'))
                        ->set_conditional_logic([
                            [
                                'field' => 'layout',
                                'value' => self::LAYOUT_IMAGE_COLUMNS,
                            ],
                        ]),
                    Field::make('rich_text', 'before_content', esc_html__('Mô tả trước bảng', 'extend-site'))
                        ->set_help_text(esc_html__('Nội dung hiển thị phía trên bảng/các cột bên phải. Có thể bỏ trống.', 'extend-site'))
                        ->set_conditional_logic([
                            [
                                'field' => 'layout',
                                'value' => self::LAYOUT_IMAGE_COLUMNS,
                            ],
                        ]),
                    Field::make('complex', 'columns', esc_html__('Bảng nội dung các lớp', 'extend-site'))
                        ->set_help_text(esc_html__('Mỗi mục là một cột trong bảng, ví dụ: Lớp phủ thứ 1, Lớp phủ thứ 2.', 'extend-site'))
                        ->set_layout('tabbed-vertical')
                        ->set_collapsed(true)
                        ->add_fields('_', esc_html__('Cột', 'extend-site'), [
                            Field::make('text', 'title', esc_html__('Tiêu đề cột', 'extend-site')),
                            Field::make('rich_text', 'content', esc_html__('Nội dung cột', 'extend-site')),
                        ])
                        ->set_header_template('<%- title ? title : "' . esc_html__('Cột', 'extend-site') . ' " + ($_index + 1) %>')
                        ->set_conditional_logic([
                            [
                                'field' => 'layout',
                                'value' => self::LAYOUT_IMAGE_COLUMNS,
                            ],
                        ]),
                    Field::make('rich_text', 'after_content', esc_html__('Ghi chú sau bảng', 'extend-site'))
                        ->set_help_text(esc_html__('Nội dung hiển thị phía dưới bảng/các cột bên phải. Có thể bỏ trống.', 'extend-site'))
                        ->set_conditional_logic([
                            [
                                'field' => 'layout',
                                'value' => self::LAYOUT_IMAGE_COLUMNS,
                            ],
                        ]),
                ])
                ->set_header_template('<%- title ? title : "' . esc_html__('Bước', 'extend-site') . ' " + ($_index + 1) %>'),
        ];
    }

    public static function get_overview_content(int $post_id): string
    {
        $content = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::CONSTRUCTION_OVERVIEW)
            : '';

        return is_string($content) ? trim($content) : '';
    }

    public static function get_construction_process(int $post_id): array
    {
        $rows = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::CONSTRUCTION_PROCESS)
            : [];

        if (is_array($rows) && !empty($rows)) {
            $normalized = self::normalize_rows($rows);

            if (self::has_useful_rows($normalized)) {
                return $normalized;
            }
        }

        $rows = get_post_meta($post_id, self::CMB_CONSTRUCTION_PROCESS, true);

        return is_array($rows) ? self::normalize_rows($rows) : [];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'overview_content' => self::get_overview_content($post_id),
            'construction_process' => self::get_construction_process($post_id),
        ];
    }

    private static function normalize_rows(array $rows): array
    {
        $normalized = [];

        foreach ($rows as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            $layout = !empty($row['layout']) && is_string($row['layout'])
                ? $row['layout']
                : self::LAYOUT_CONTENT;
            $content = isset($row['content']) ? (string) $row['content'] : '';
            $before_content = isset($row['before_content']) ? (string) $row['before_content'] : '';
            $after_content = isset($row['after_content']) ? (string) $row['after_content'] : '';
            $cards = !empty($row['cards']) && is_array($row['cards']) ? self::normalize_cards($row['cards']) : [];
            $columns = !empty($row['columns']) && is_array($row['columns']) ? self::normalize_columns($row['columns']) : [];
            $image_id = !empty($row['image']) ? (int) $row['image'] : 0;

            if (!in_array($layout, [self::LAYOUT_CONTENT, self::LAYOUT_CARDS, self::LAYOUT_IMAGE_COLUMNS], true)) {
                $layout = self::LAYOUT_CONTENT;
            }

            if (trim($content) === '' && trim($before_content) === '' && trim($after_content) === '' && empty($cards) && empty($columns) && !$image_id) {
                continue;
            }

            $number = count($normalized) + 1;

            $normalized[] = [
                'step' => sprintf(esc_html__('Bước %d', 'extend-site'), $number),
                'number' => $number,
                'title' => !empty($row['title']) ? trim((string) $row['title']) : '',
                'subtitle' => !empty($row['subtitle']) ? trim((string) $row['subtitle']) : '',
                'layout' => $layout,
                'content' => $content,
                'before_content' => $before_content,
                'after_content' => $after_content,
                'cards' => $cards,
                'image_id' => $image_id && wp_attachment_is_image($image_id) ? $image_id : 0,
                'columns' => $columns,
            ];
        }

        return $normalized;
    }

    private static function normalize_cards(array $cards): array
    {
        $normalized = [];

        foreach ($cards as $card) {
            if (!is_array($card)) {
                continue;
            }

            $image_id = !empty($card['image']) ? (int) $card['image'] : 0;
            $title = !empty($card['title']) ? trim((string) $card['title']) : '';
            $content = isset($card['content']) ? (string) $card['content'] : '';

            if (!$image_id && $title === '' && trim($content) === '') {
                continue;
            }

            $normalized[] = [
                'image_id' => $image_id && wp_attachment_is_image($image_id) ? $image_id : 0,
                'title' => $title,
                'content' => $content,
            ];
        }

        return $normalized;
    }

    private static function normalize_columns(array $columns): array
    {
        $normalized = [];

        foreach ($columns as $column) {
            if (!is_array($column)) {
                continue;
            }

            $title = !empty($column['title']) ? trim((string) $column['title']) : '';
            $content = isset($column['content']) ? (string) $column['content'] : '';

            if ($title === '' && trim($content) === '') {
                continue;
            }

            $normalized[] = [
                'title' => $title,
                'content' => $content,
            ];
        }

        return $normalized;
    }

    private static function has_useful_rows(array $rows): bool
    {
        foreach ($rows as $row) {
            if (
                !empty(trim((string) ($row['content'] ?? ''))) ||
                !empty(trim((string) ($row['before_content'] ?? ''))) ||
                !empty(trim((string) ($row['after_content'] ?? ''))) ||
                !empty($row['cards']) ||
                !empty($row['columns']) ||
                !empty($row['image_id'])
            ) {
                return true;
            }
        }

        return false;
    }
}
