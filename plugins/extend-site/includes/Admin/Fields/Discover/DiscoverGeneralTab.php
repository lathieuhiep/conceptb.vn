<?php

namespace ExtendSite\Admin\Fields\Discover;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class DiscoverGeneralTab implements FieldTabIF
{
    public const COLOR = 'es_discover_color';
    public const COLOR_URL = 'es_discover_color_url';
    public const CLASSIFY = 'es_discover_classify';
    public const CONSTRUCTION_TOOLS = 'es_discover_construction_tools';
    public const VIDEO = 'es_discover_video';

    private const CMB_COLOR = 'paint_cmb_discover_color';
    private const CMB_COLOR_URL = 'paint_cmb_discover_color_url';
    private const CMB_CLASSIFY = 'paint_cmb_discover_classify';
    private const CMB_CONSTRUCTION_TOOLS = 'paint_cmb_discover_construction_tools';
    private const CMB_VIDEO = 'paint_cmb_discover_video';

    public static function fields(): array
    {
        return [
            Field::make('text', self::COLOR, esc_html__('Mã màu', 'extend-site')),
            Field::make('text', self::COLOR_URL, esc_html__('Link mã màu', 'extend-site'))
                ->set_attribute('type', 'url')
                ->set_default_value('#'),
            Field::make('text', self::CLASSIFY, esc_html__('Phân loại', 'extend-site')),
            Field::make('media_gallery', self::CONSTRUCTION_TOOLS, esc_html__('Dụng cụ thi công', 'extend-site'))
                ->set_type('image')
                ->set_duplicates_allowed(false),
            Field::make('text', self::VIDEO, esc_html__('Video hướng dẫn', 'extend-site'))
                ->set_attribute('type', 'url')
                ->set_help_text(esc_html__('Nhập URL youtube, twitter hoặc instagram.', 'extend-site')),
        ];
    }

    public static function get_color(int $post_id): string
    {
        return self::get_scalar($post_id, self::COLOR, self::CMB_COLOR);
    }

    public static function get_color_url(int $post_id): string
    {
        return self::get_scalar($post_id, self::COLOR_URL, self::CMB_COLOR_URL);
    }

    public static function get_classify(int $post_id): string
    {
        return self::get_scalar($post_id, self::CLASSIFY, self::CMB_CLASSIFY);
    }

    public static function get_construction_tool_ids(int $post_id): array
    {
        $gallery = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::CONSTRUCTION_TOOLS)
            : [];

        if (is_array($gallery) && !empty($gallery)) {
            $image_ids = self::normalize_attachment_ids($gallery);

            if (!empty($image_ids)) {
                return $image_ids;
            }
        }

        $gallery = self::get_first_non_empty_meta($post_id, self::CMB_CONSTRUCTION_TOOLS);

        if (!is_array($gallery)) {
            return [];
        }

        $image_ids = [];

        foreach ($gallery as $id => $url) {
            $image_id = is_numeric($id) && self::is_valid_image_id((int) $id) ? (int) $id : 0;

            if (!$image_id && is_numeric($url) && self::is_valid_image_id((int) $url)) {
                $image_id = (int) $url;
            }

            if (!$image_id && is_string($url)) {
                $image_id = self::attachment_id_from_url($url);
            }

            if ($image_id) {
                $image_ids[] = $image_id;
            }
        }

        return self::normalize_attachment_ids($image_ids);
    }

    public static function get_video(int $post_id): string
    {
        return self::get_scalar($post_id, self::VIDEO, self::CMB_VIDEO);
    }

    public static function get_data(int $post_id): array
    {
        return [
            'color' => self::get_color($post_id),
            'color_url' => self::get_color_url($post_id),
            'classify' => self::get_classify($post_id),
            'construction_tool_ids' => self::get_construction_tool_ids($post_id),
            'video' => self::get_video($post_id),
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
        return array_values(array_unique(array_filter(array_map('absint', $ids), [self::class, 'is_valid_image_id'])));
    }

    private static function is_valid_image_id(int $image_id): bool
    {
        return $image_id > 0 && wp_attachment_is_image($image_id);
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
