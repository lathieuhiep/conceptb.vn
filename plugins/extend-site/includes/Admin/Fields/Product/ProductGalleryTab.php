<?php

namespace ExtendSite\Admin\Fields\Product;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProductGalleryTab implements FieldTabIF
{
    public const GALLERY = 'es_product_gallery';

    private const CMB_GALLERY = 'paint_cmb_product_gallery';

    public static function fields(): array
    {
        return [
            Field::make('complex', self::GALLERY, esc_html__('Hình ảnh thực tế', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields('_', esc_html__('Ảnh', 'extend-site'), [
                    Field::make('select', 'style', esc_html__('Kiểu hiển thị', 'extend-site'))
                        ->set_default_value('normal')
                        ->add_options([
                            'normal' => esc_html__('Bình thường', 'extend-site'),
                            'full' => esc_html__('Full', 'extend-site'),
                        ]),
                    Field::make('image', 'image', esc_html__('Chọn ảnh', 'extend-site')),
                ])
                ->set_header_template(  esc_html__('Ảnh', 'extend-site') . ' <%- $_index + 1 %>'),
        ];
    }

    public static function get_gallery(int $post_id): array
    {
        $rows = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::GALLERY)
            : [];

        if (is_array($rows) && !empty($rows)) {
            return self::normalize_rows($rows);
        }

        $rows = get_post_meta($post_id, self::CMB_GALLERY, true);

        return is_array($rows) ? self::normalize_rows($rows) : [];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'gallery' => self::get_gallery($post_id),
        ];
    }

    private static function normalize_rows(array $rows): array
    {
        $normalized = [];

        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }

            $image_id = 0;

            if (!empty($row['image'])) {
                $image_id = is_numeric($row['image'])
                    ? (int) $row['image']
                    : attachment_url_to_postid((string) $row['image']);
            }

            if (!$image_id && !empty($row['image_id'])) {
                $image_id = (int) $row['image_id'];
            }

            if (!$image_id) {
                continue;
            }

            $normalized[] = [
                'style' => !empty($row['style']) ? (string) $row['style'] : 'normal',
                'image_id' => $image_id,
            ];
        }

        return $normalized;
    }
}
