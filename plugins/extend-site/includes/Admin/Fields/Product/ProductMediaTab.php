<?php

namespace ExtendSite\Admin\Fields\Product;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProductMediaTab implements FieldTabIF
{
    public const BANNER = 'es_product_banner';
    public const IMAGE_HOVER = 'es_product_image_hover';

    private const CMB_IMAGE_HOVER = 'paint_cmb_product_image_feature_hover';

    public static function side_fields(): array
    {
        return [
            Field::make('image', self::IMAGE_HOVER, esc_html__('Ảnh phụ', 'extend-site')),
        ];
    }

    public static function fields(): array
    {
        return [
            Field::make('image', self::BANNER, esc_html__('Banner', 'extend-site')),
        ];
    }

    public static function get_banner_id(int $post_id): int
    {
        $image_id = function_exists('carbon_get_post_meta')
            ? (int) carbon_get_post_meta($post_id, self::BANNER)
            : 0;

        return $image_id && wp_attachment_is_image($image_id) ? $image_id : 0;
    }

    public static function get_image_hover_id(int $post_id): int
    {
        $image_id = function_exists('carbon_get_post_meta')
            ? (int) carbon_get_post_meta($post_id, self::IMAGE_HOVER)
            : 0;

        if ($image_id) {
            return $image_id;
        }

        return self::attachment_id_from_cmb_file($post_id, self::CMB_IMAGE_HOVER);
    }

    public static function get_data(int $post_id): array
    {
        return [
            'banner_id' => self::get_banner_id($post_id),
            'image_hover_id' => self::get_image_hover_id($post_id),
        ];
    }

    private static function attachment_id_from_cmb_file(int $post_id, string $old_key): int
    {
        $image_id = (int) get_post_meta($post_id, $old_key . '_id', true);

        if ($image_id) {
            return $image_id;
        }

        $image_url = get_post_meta($post_id, $old_key, true);

        if (!is_string($image_url) || $image_url === '') {
            return 0;
        }

        return self::attachment_id_from_url($image_url);
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
}
