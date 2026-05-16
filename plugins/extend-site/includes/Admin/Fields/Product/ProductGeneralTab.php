<?php

namespace ExtendSite\Admin\Fields\Product;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;
use ExtendSite\Helpers\ESHelpers;

defined('ABSPATH') || exit;

class ProductGeneralTab implements FieldTabIF
{
    public const CODE = 'es_product_code';
    public const COLOR = 'es_product_color';

    private const CMB_CODE = 'paint_cmb_product_code';
    private const CMB_COLOR = 'paint_cmb_options_product_color';

    public static function fields(): array
    {
        return [
            Field::make('text', self::CODE, esc_html__('Mã sản phẩm', 'extend-site')),

            Field::make('select', self::COLOR, esc_html__('Chọn bảng màu', 'extend-site'))
                ->set_help_text(esc_html__('Chọn danh mục chứa bảng màu, nếu danh mục nhiều hơn 1 bảng màu trở lên sẽ hiển thị dạng kiểu vân. Bảng màu được tạo ở mục "Mã màu sơn".', 'extend-site'))
                ->add_options([self::class, 'get_color_code_categories']),
        ];
    }

    public static function get_code(int $post_id): string
    {
        return (string) self::get_meta_with_fallback($post_id, self::CODE, self::CMB_CODE, '');
    }

    public static function get_color_cat_id(int $post_id): int
    {
        return (int) self::get_meta_with_fallback($post_id, self::COLOR, self::CMB_COLOR, 0);
    }

    public static function get_data(int $post_id): array
    {
        return [
            'code' => self::get_code($post_id),
            'color_cat_id' => self::get_color_cat_id($post_id),
        ];
    }

    public static function get_color_code_categories(): array
    {
        return ESHelpers::get_tax_list_with_count('paint_color_code_cat');
    }

    private static function get_meta_with_fallback(int $post_id, string $carbon_key, string $cmb_key, $default = null)
    {
        $value = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($post_id, $carbon_key) : null;

        if (self::has_value($value)) {
            return $value;
        }

        $value = get_post_meta($post_id, $cmb_key, true);

        return self::has_value($value) ? $value : $default;
    }

    private static function has_value($value): bool
    {
        if (is_array($value)) {
            return !empty($value);
        }

        return $value !== '' && $value !== null;
    }
}
