<?php

namespace ExtendSite\Admin\Fields\Tool;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ToolSpecificationsTab implements FieldTabIF
{
    public const URL = 'es_tool_url';
    public const PRICE = 'es_tool_price';
    public const SUBSTANCE = 'es_tool_substance';
    public const SIZE = 'es_tool_size';
    public const COLOR = 'es_tool_color';
    public const WEIGHT = 'es_tool_weight';

    private const CMB_URL = 'paint_cmb_tool_specifications_url';
    private const CMB_PRICE = 'paint_cmb_tool_specifications_price';
    private const CMB_SUBSTANCE = 'paint_cmb_tool_specifications_substance';
    private const CMB_SIZE = 'paint_cmb_tool_specifications_size';
    private const CMB_COLOR = 'paint_cmb_tool_specifications_color';
    private const CMB_WEIGHT = 'paint_cmb_tool_specifications_weight';

    public static function fields(): array
    {
        return [
            Field::make('text', self::URL, esc_html__('Shopee URL', 'extend-site'))
                ->set_attribute('type', 'url')
                ->set_default_value('https://shopee.vn/'),
            Field::make('text', self::PRICE, esc_html__('Giá', 'extend-site'))
                ->set_attribute('type', 'number')
                ->set_attribute('min', '1'),
            Field::make('text', self::SUBSTANCE, esc_html__('Chất liệu', 'extend-site'))
                ->set_default_value(esc_html__('Nhựa dẻo cao cấp', 'extend-site')),
            Field::make('text', self::SIZE, esc_html__('Kích thước dụng cụ', 'extend-site'))
                ->set_default_value('25*15*12'),
            Field::make('text', self::COLOR, esc_html__('Màu sắc', 'extend-site'))
                ->set_default_value(esc_html__('Trắng - Đỏ', 'extend-site')),
            Field::make('text', self::WEIGHT, esc_html__('Trọng lượng', 'extend-site'))
                ->set_default_value(esc_html__('0.5kg - 5 lít', 'extend-site')),
        ];
    }

    public static function get_url(int $post_id): string
    {
        return self::get_scalar($post_id, self::URL, self::CMB_URL);
    }

    public static function get_price(int $post_id): float
    {
        return (float) self::get_scalar($post_id, self::PRICE, self::CMB_PRICE);
    }

    public static function get_substance(int $post_id): string
    {
        return self::get_scalar($post_id, self::SUBSTANCE, self::CMB_SUBSTANCE);
    }

    public static function get_size(int $post_id): string
    {
        return self::get_scalar($post_id, self::SIZE, self::CMB_SIZE);
    }

    public static function get_color(int $post_id): string
    {
        return self::get_scalar($post_id, self::COLOR, self::CMB_COLOR);
    }

    public static function get_weight(int $post_id): string
    {
        return self::get_scalar($post_id, self::WEIGHT, self::CMB_WEIGHT);
    }

    public static function get_data(int $post_id): array
    {
        return [
            'url' => self::get_url($post_id),
            'price' => self::get_price($post_id),
            'substance' => self::get_substance($post_id),
            'size' => self::get_size($post_id),
            'color' => self::get_color($post_id),
            'weight' => self::get_weight($post_id),
        ];
    }

    private static function get_scalar(int $post_id, string $new_key, string $old_key): string
    {
        $value = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, $new_key)
            : '';

        if ($value !== '' && $value !== null && !is_array($value)) {
            return (string) $value;
        }

        $value = self::get_first_non_empty_meta($post_id, $old_key);

        return !is_array($value) ? (string) $value : '';
    }

    private static function get_first_non_empty_meta(int $post_id, string $key)
    {
        $values = get_post_meta($post_id, $key, false);

        foreach ($values as $value) {
            if (!is_array($value) && $value !== '' && $value !== null) {
                return $value;
            }
        }

        return '';
    }
}
