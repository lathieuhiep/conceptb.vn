<?php

namespace ExtendSite\Admin\Fields\ColorCode;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ColorCodeStandardTab implements FieldTabIF
{
    public const NAME = 'es_color_code_name';
    public const STANDARD = 'es_color_code_standard';

    private const CMB_NAME = 'paint_cmb_color_code_name';
    private const CMB_STANDARD = 'paint_cmb_color_code_standard';

    public static function fields(): array
    {
        return [
            Field::make('text', self::NAME, esc_html__('Tên hiệu', 'extend-site')),
            Field::make('complex', self::STANDARD, esc_html__('Bảng màu', 'extend-site'))
                ->set_layout('tabbed-horizontal')
                ->set_collapsed(true)
                ->setup_labels([
                    'plural_name' => esc_html__('Mã sơn', 'extend-site'),
                    'singular_name' => esc_html__('Mã sơn', 'extend-site'),
                ])
                ->add_fields('_', esc_html__('Mã sơn', 'extend-site'), [
                    Field::make('text', 'paint_number', esc_html__('Số hiệu', 'extend-site')),
                    Field::make('image', 'image', esc_html__('Ảnh mã màu', 'extend-site')),
                    Field::make('image', 'featured_image', esc_html__('Ảnh chính', 'extend-site')),
                    Field::make('rich_text', 'describe', esc_html__('Mô tả', 'extend-site')),
                    Field::make('rich_text', 'note', esc_html__('Ghi chú', 'extend-site')),
                ])
                ->set_header_template('<% if (paint_number) { %><%- paint_number %><% } else { %>' . esc_html__('Mã sơn', 'extend-site') . ' <%- $_index + 1 %><% } %>'),
        ];
    }

    public static function get_name(int $post_id): string
    {
        $name = function_exists('carbon_get_post_meta')
            ? (string) carbon_get_post_meta($post_id, self::NAME)
            : '';

        if ($name !== '') {
            return $name;
        }

        return (string) self::get_first_non_empty_meta($post_id, self::CMB_NAME);
    }

    public static function get_standard(int $post_id): array
    {
        $rows = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::STANDARD)
            : [];

        if (is_array($rows) && !empty($rows)) {
            $normalized = self::normalize_rows($rows);

            if (!empty($normalized)) {
                return $normalized;
            }
        }

        $rows = self::get_first_non_empty_meta($post_id, self::CMB_STANDARD);

        return is_array($rows) ? self::normalize_rows($rows) : [];
    }

    public static function get_standard_item(int $post_id, $key): array
    {
        $rows = self::get_standard($post_id);
        $key = is_numeric($key) ? (int) $key : $key;

        return isset($rows[$key]) && is_array($rows[$key]) ? $rows[$key] : [];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'name' => self::get_name($post_id),
            'standard' => self::get_standard($post_id),
        ];
    }

    private static function normalize_rows(array $rows): array
    {
        $normalized = [];

        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }

            $image_id = self::image_id_from_row($row, 'image');
            $featured_image_id = self::image_id_from_row($row, 'featured_image');
            $paint_number = isset($row['paint_number']) ? (string) $row['paint_number'] : '';

            if (!$image_id && !$featured_image_id && trim($paint_number) === '') {
                continue;
            }

            $normalized[] = [
                'paint_number' => $paint_number,
                'image_id' => $image_id,
                'featured_image_id' => $featured_image_id,
                'describe' => isset($row['describe']) ? (string) $row['describe'] : '',
                'note' => isset($row['note']) ? (string) $row['note'] : '',
            ];
        }

        return $normalized;
    }

    private static function image_id_from_row(array $row, string $key): int
    {
        $cmb_id_key = $key . '_id';

        if (!empty($row[$cmb_id_key])) {
            return (int) $row[$cmb_id_key];
        }

        if (!empty($row[$key])) {
            if (is_numeric($row[$key])) {
                return (int) $row[$key];
            }

            if (is_string($row[$key])) {
                return self::attachment_id_from_url($row[$key]);
            }
        }

        return 0;
    }

    private static function attachment_id_from_url(string $image_url): int
    {
        $image_id = (int) attachment_url_to_postid($image_url);

        if ($image_id) {
            return $image_id;
        }

        $path = wp_parse_url($image_url, PHP_URL_PATH);

        if (!is_string($path) || $path === '') {
            return 0;
        }

        $uploads_pos = strpos($path, '/wp-content/uploads/');

        if ($uploads_pos === false) {
            return 0;
        }

        $attached_file = ltrim(substr($path, $uploads_pos + strlen('/wp-content/uploads/')), '/');

        if ($attached_file === '') {
            return 0;
        }

        global $wpdb;

        return (int) $wpdb->get_var($wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value = %s LIMIT 1",
            $attached_file
        ));
    }

    private static function get_first_non_empty_meta(int $post_id, string $key)
    {
        $values = get_post_meta($post_id, $key, false);

        foreach ($values as $value) {
            if (is_array($value) && !empty($value)) {
                return $value;
            }

            if (!is_array($value) && $value !== '' && $value !== null) {
                return $value;
            }
        }

        return '';
    }
}
