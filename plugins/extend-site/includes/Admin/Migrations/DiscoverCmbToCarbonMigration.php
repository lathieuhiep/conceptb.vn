<?php

namespace ExtendSite\Admin\Migrations;

use ExtendSite\Admin\Fields\Discover\DiscoverGeneralTab;
use ExtendSite\PostType\DiscoverPostType;

defined('ABSPATH') || exit;

class DiscoverCmbToCarbonMigration
{
    private const OPTION_KEY = 'extend_site_migrated_discover_cmb_to_carbon';
    private const LOCK_KEY = 'extend_site_migrating_discover_cmb_to_carbon';

    public static function run(): void
    {
        if (!function_exists('carbon_set_post_meta') || !function_exists('carbon_get_post_meta')) {
            return;
        }

        if (get_transient(self::LOCK_KEY)) {
            return;
        }

        set_transient(self::LOCK_KEY, 1, 10 * MINUTE_IN_SECONDS);

        $has_run = (bool) get_option(self::OPTION_KEY);
        $migrated = 0;
        $post_ids = get_posts([
            'post_type' => DiscoverPostType::SLUG,
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);

        foreach ($post_ids as $post_id) {
            $migrated += self::migrate_discover((int) $post_id);
        }

        if (!$has_run) {
            update_option(self::OPTION_KEY, [
                'migrated_at' => current_time('mysql'),
                'post_count' => count($post_ids),
                'field_count' => $migrated,
            ], false);
        } else {
            update_option(self::OPTION_KEY . '_last_sync', [
                'synced_at' => current_time('mysql'),
                'post_count' => count($post_ids),
                'field_count' => $migrated,
            ], false);
        }

        delete_transient(self::LOCK_KEY);
    }

    private static function migrate_discover(int $post_id): int
    {
        $migrated = 0;

        $migrated += self::copy_scalar($post_id, 'paint_cmb_discover_color', DiscoverGeneralTab::COLOR);
        $migrated += self::copy_scalar($post_id, 'paint_cmb_discover_color_url', DiscoverGeneralTab::COLOR_URL);
        $migrated += self::copy_scalar($post_id, 'paint_cmb_discover_classify', DiscoverGeneralTab::CLASSIFY);
        $migrated += self::copy_media_gallery($post_id, 'paint_cmb_discover_construction_tools', DiscoverGeneralTab::CONSTRUCTION_TOOLS);
        $migrated += self::copy_scalar($post_id, 'paint_cmb_discover_video', DiscoverGeneralTab::VIDEO);

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

    private static function copy_media_gallery(int $post_id, string $old_key, string $new_key): int
    {
        if (self::has_valid_carbon_gallery($post_id, $new_key)) {
            return 0;
        }

        $gallery = self::get_first_non_empty_meta($post_id, $old_key);

        if (!is_array($gallery) || empty($gallery)) {
            return 0;
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

        $image_ids = array_values(array_unique(array_filter($image_ids)));

        if (empty($image_ids)) {
            return 0;
        }

        carbon_set_post_meta($post_id, $new_key, $image_ids);

        return 1;
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

    private static function has_valid_carbon_gallery(int $post_id, string $key): bool
    {
        $value = carbon_get_post_meta($post_id, $key);

        if (!is_array($value) || empty($value)) {
            return false;
        }

        foreach ($value as $image_id) {
            if (self::is_valid_image_id((int) $image_id)) {
                return true;
            }
        }

        return false;
    }

    private static function is_valid_image_id(int $image_id): bool
    {
        return $image_id > 0 && wp_attachment_is_image($image_id);
    }
}
