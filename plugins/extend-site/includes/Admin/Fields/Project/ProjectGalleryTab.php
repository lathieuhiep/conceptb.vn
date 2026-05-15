<?php

namespace ExtendSite\Admin\Fields\Project;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProjectGalleryTab implements FieldTabIF
{
    public const GALLERY = 'es_project_gallery';

    private const CMB_GALLERY = 'paint_cmb_project_gallery';

    public static function fields(): array
    {
        return [
            Field::make('media_gallery', self::GALLERY, esc_html__('Gallery', 'extend-site'))
                ->set_type('image')
                ->set_duplicates_allowed(false),
        ];
    }

    public static function get_gallery_ids(int $post_id): array
    {
        $gallery = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::GALLERY)
            : [];

        if (is_array($gallery) && !empty($gallery)) {
            return self::normalize_attachment_ids($gallery);
        }

        $gallery = self::get_first_non_empty_meta($post_id, self::CMB_GALLERY);

        if (!is_array($gallery)) {
            return [];
        }

        $image_ids = [];

        foreach ($gallery as $id => $url) {
            $image_id = is_numeric($id) ? (int) $id : 0;

            if (!$image_id && is_string($url)) {
                $image_id = self::attachment_id_from_url($url);
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
            'gallery_ids' => self::get_gallery_ids($post_id),
        ];
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

    private static function normalize_attachment_ids(array $ids): array
    {
        return array_values(array_unique(array_filter(array_map('absint', $ids))));
    }

    private static function get_first_non_empty_meta(int $post_id, string $key)
    {
        $values = get_post_meta($post_id, $key, false);

        foreach ($values as $value) {
            if (is_array($value) && !empty($value)) {
                return $value;
            }
        }

        return [];
    }
}
