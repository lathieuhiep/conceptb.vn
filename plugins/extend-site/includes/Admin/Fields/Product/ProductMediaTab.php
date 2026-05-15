<?php

namespace ExtendSite\Admin\Fields\Product;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProductMediaTab implements FieldTabIF
{
    public const IMAGE_HOVER = 'es_product_image_hover';
    public const IMAGE_GALLERY = 'es_product_image_gallery';

    private const CMB_IMAGE_HOVER = 'paint_cmb_product_image_feature_hover';
    private const CMB_IMAGE_GALLERY = 'paint_cmb_product_image_gallery';

    public static function side_fields(): array
    {
        return [
            Field::make('image', self::IMAGE_HOVER, esc_html__('Ảnh phụ', 'extend-site')),
        ];
    }

    public static function fields(): array
    {
        return [
            Field::make('media_gallery', self::IMAGE_GALLERY, esc_html__('Album sản phẩm', 'extend-site'))
                ->set_type('image')
                ->set_duplicates_allowed(false)
                ->set_help_text(esc_html__('Ảnh sẽ hiển thị ở chi tiết sản phẩm, nếu không có sẽ thay bằng ảnh đại diện.', 'extend-site')),
        ];
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

    public static function get_image_gallery_ids(int $post_id): array
    {
        $gallery = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::IMAGE_GALLERY)
            : [];

        if (is_array($gallery) && !empty($gallery)) {
            return self::normalize_attachment_ids($gallery);
        }

        $cmb_gallery = get_post_meta($post_id, self::CMB_IMAGE_GALLERY, true);

        if (!is_array($cmb_gallery)) {
            return [];
        }

        $image_ids = [];

        foreach ($cmb_gallery as $id => $url) {
            $image_id = is_numeric($id) ? (int) $id : 0;

            if (!$image_id && is_string($url)) {
                $image_id = attachment_url_to_postid($url);
            }

            if ($image_id) {
                $image_ids[] = $image_id;
            }
        }

        return self::normalize_attachment_ids($image_ids);
    }

    public static function get_data(int $post_id): array
    {
        return [
            'image_hover_id' => self::get_image_hover_id($post_id),
            'image_gallery_ids' => self::get_image_gallery_ids($post_id),
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

        return (int) attachment_url_to_postid($image_url);
    }

    private static function normalize_attachment_ids(array $ids): array
    {
        return array_values(array_unique(array_filter(array_map('absint', $ids))));
    }
}
