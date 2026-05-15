<?php

namespace ExtendSite\Admin\Fields\Project;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProjectGeneralTab implements FieldTabIF
{
    public const BANNER = 'es_project_banner';
    public const MODEL = 'es_project_model';
    public const MASS = 'es_project_mass';
    public const COMPLETION_TIME = 'es_project_completion_time';
    public const CONSTRUCTION = 'es_project_construction';

    private const CMB_BANNER = 'paint_cmb_project_banner';
    private const CMB_MODEL = 'paint_cmb_project_model';
    private const CMB_MASS = 'paint_cmb_project_mass';
    private const CMB_COMPLETION_TIME = 'paint_cmb_project_completion_time';
    private const CMB_CONSTRUCTION = 'paint_cmb_project_construction';

    public static function fields(): array
    {
        return [
            Field::make('image', self::BANNER, esc_html__('Banner', 'extend-site')),
            Field::make('text', self::MODEL, esc_html__('Loại sơn', 'extend-site')),
            Field::make('text', self::MASS, esc_html__('Khối lượng', 'extend-site')),
            Field::make('text', self::COMPLETION_TIME, esc_html__('Thời gian hoàn thành', 'extend-site')),
            Field::make('text', self::CONSTRUCTION, esc_html__('Loại hình thi công', 'extend-site')),
        ];
    }

    public static function get_banner_id(int $post_id): int
    {
        $image_id = function_exists('carbon_get_post_meta')
            ? (int) carbon_get_post_meta($post_id, self::BANNER)
            : 0;

        if ($image_id) {
            return $image_id;
        }

        return self::attachment_id_from_cmb_file($post_id, self::CMB_BANNER);
    }

    public static function get_model(int $post_id): string
    {
        return self::get_scalar($post_id, self::MODEL, self::CMB_MODEL);
    }

    public static function get_mass(int $post_id): string
    {
        return self::get_scalar($post_id, self::MASS, self::CMB_MASS);
    }

    public static function get_completion_time(int $post_id): string
    {
        return self::get_scalar($post_id, self::COMPLETION_TIME, self::CMB_COMPLETION_TIME);
    }

    public static function get_construction(int $post_id): string
    {
        return self::get_scalar($post_id, self::CONSTRUCTION, self::CMB_CONSTRUCTION);
    }

    public static function get_data(int $post_id): array
    {
        return [
            'banner_id' => self::get_banner_id($post_id),
            'model' => self::get_model($post_id),
            'mass' => self::get_mass($post_id),
            'completion_time' => self::get_completion_time($post_id),
            'construction' => self::get_construction($post_id),
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

    private static function attachment_id_from_cmb_file(int $post_id, string $old_key): int
    {
        $image_id = (int) get_post_meta($post_id, $old_key . '_id', true);

        if ($image_id) {
            return $image_id;
        }

        $image_url = self::get_first_non_empty_meta($post_id, $old_key);

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
