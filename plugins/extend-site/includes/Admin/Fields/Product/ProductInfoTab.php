<?php

namespace ExtendSite\Admin\Fields\Product;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProductInfoTab implements FieldTabIF
{
    public const TECHNICAL_SPECS = 'es_product_info_technical_specs';
    public const INTRO_TITLE = 'es_product_info_intro_title';
    public const INTRO_CONTENT = 'es_product_info_intro_content';
    public const CONSTRUCTION_NOTES = 'es_product_info_construction_notes';

    public static function fields(): array
    {
        return array_merge(
            self::technical_spec_fields(),
            self::intro_fields(),
            self::construction_note_fields()
        );
    }

    public static function technical_spec_fields(): array
    {
        return [
            Field::make('complex', self::TECHNICAL_SPECS, esc_html__('Thông số kỹ thuật', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->set_collapsed(true)
                ->add_fields('_', esc_html__('Thông số', 'extend-site'), [
                    Field::make('text', 'spec_label', esc_html__('Tên thông số', 'extend-site')),
                    Field::make('text', 'spec_value', esc_html__('Giá trị', 'extend-site')),
                ])
                ->set_header_template('<%- spec_label ? spec_label : "' . esc_html__('Thông số', 'extend-site') . ' " + ($_index + 1) %>'),
        ];
    }

    public static function intro_fields(): array
    {
        return [
            Field::make('text', self::INTRO_TITLE, esc_html__('Tiêu đề giới thiệu', 'extend-site')),

            Field::make('rich_text', self::INTRO_CONTENT, esc_html__('Nội dung giới thiệu', 'extend-site')),
        ];
    }

    public static function construction_note_fields(): array
    {
        return [
            Field::make('rich_text', self::CONSTRUCTION_NOTES, esc_html__('Lưu ý thi công', 'extend-site')),
        ];
    }

    public static function get_technical_specs(int $post_id): array
    {
        $rows = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::TECHNICAL_SPECS)
            : [];

        return is_array($rows) ? self::normalize_technical_specs($rows) : [];
    }

    public static function get_intro(int $post_id): array
    {
        return [
            'title' => self::get_string_meta($post_id, self::INTRO_TITLE),
            'content' => self::get_string_meta($post_id, self::INTRO_CONTENT),
        ];
    }

    public static function get_construction_notes(int $post_id): string
    {
        return self::get_string_meta($post_id, self::CONSTRUCTION_NOTES);
    }

    public static function get_data(int $post_id): array
    {
        return [
            'technical_specs' => self::get_technical_specs($post_id),
            'intro' => self::get_intro($post_id),
            'construction_notes' => self::get_construction_notes($post_id),
        ];
    }

    private static function normalize_technical_specs(array $rows): array
    {
        $normalized = [];

        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }

            $label = trim((string) ($row['spec_label'] ?? ''));
            $value = trim((string) ($row['spec_value'] ?? ''));

            if ($label === '' && $value === '') {
                continue;
            }

            $normalized[] = [
                'label' => $label,
                'value' => $value,
            ];
        }

        return $normalized;
    }

    private static function get_string_meta(int $post_id, string $key): string
    {
        $value = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, $key)
            : '';

        return is_string($value) ? trim($value) : '';
    }
}
