<?php

namespace ExtendSite\Admin\Migrations;

use ExtendSite\Admin\Fields\ColorCode\ColorCodeStandardTab;
use ExtendSite\PostType\ColorCodePostType;

defined('ABSPATH') || exit;

class ColorCodeCmbToCarbonMigration
{
    private const OPTION_KEY = 'extend_site_migrated_color_code_cmb_to_carbon';
    private const LOCK_KEY = 'extend_site_migrating_color_code_cmb_to_carbon';

    public static function run(): void
    {
        if (get_option(self::OPTION_KEY)) {
            return;
        }

        if (!function_exists('carbon_set_post_meta') || !function_exists('carbon_get_post_meta')) {
            return;
        }

        if (get_transient(self::LOCK_KEY)) {
            return;
        }

        set_transient(self::LOCK_KEY, 1, 10 * MINUTE_IN_SECONDS);

        $migrated = 0;
        $post_ids = get_posts([
            'post_type' => ColorCodePostType::SLUG,
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);

        foreach ($post_ids as $post_id) {
            $migrated += self::migrate_color_code((int) $post_id);
        }

        update_option(self::OPTION_KEY, [
            'migrated_at' => current_time('mysql'),
            'post_count' => count($post_ids),
            'field_count' => $migrated,
        ], false);

        delete_transient(self::LOCK_KEY);
    }

    private static function migrate_color_code(int $post_id): int
    {
        $migrated = 0;

        $migrated += self::copy_scalar(
            $post_id,
            'paint_cmb_color_code_name',
            ColorCodeStandardTab::NAME
        );

        $migrated += self::copy_standard(
            $post_id,
            'paint_cmb_color_code_standard',
            ColorCodeStandardTab::STANDARD
        );

        return $migrated;
    }

    private static function copy_scalar(int $post_id, string $old_key, string $new_key): int
    {
        if (self::has_carbon_value($post_id, $new_key)) {
            return 0;
        }

        $value = self::get_first_non_empty_meta($post_id, $old_key);

        if ($value === '' || $value === null || is_array($value)) {
            return 0;
        }

        carbon_set_post_meta($post_id, $new_key, $value);

        return 1;
    }

    private static function copy_standard(int $post_id, string $old_key, string $new_key): int
    {
        if (self::has_carbon_value($post_id, $new_key)) {
            return 0;
        }

        $rows = self::get_first_non_empty_meta($post_id, $old_key);

        if (!is_array($rows) || empty($rows)) {
            return 0;
        }

        $new_rows = [];

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

            $new_rows[] = [
                '_type' => '_',
                'paint_number' => $paint_number,
                'image' => $image_id,
                'featured_image' => $featured_image_id,
                'describe' => isset($row['describe']) ? (string) $row['describe'] : '',
                'note' => isset($row['note']) ? (string) $row['note'] : '',
            ];
        }

        if (empty($new_rows)) {
            return 0;
        }

        carbon_set_post_meta($post_id, $new_key, $new_rows);

        return 1;
    }

    private static function image_id_from_row(array $row, string $key): int
    {
        $cmb_id_key = $key . '_id';

        if (!empty($row[$cmb_id_key])) {
            return (int) $row[$cmb_id_key];
        }

        if (empty($row[$key])) {
            return 0;
        }

        if (is_numeric($row[$key])) {
            return (int) $row[$key];
        }

        if (is_string($row[$key])) {
            return self::attachment_id_from_url($row[$key]);
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

    private static function has_carbon_value(int $post_id, string $key): bool
    {
        $value = carbon_get_post_meta($post_id, $key);

        if (is_array($value)) {
            return !empty($value);
        }

        return $value !== '' && $value !== null;
    }
}
