<?php

namespace ExtendSite\Admin\Migrations;

use ExtendSite\Admin\Fields\Project\ProjectGalleryTab;
use ExtendSite\Admin\Fields\Project\ProjectGeneralTab;
use ExtendSite\PostType\ProjectPostType;

defined('ABSPATH') || exit;

class ProjectCmbToCarbonMigration
{
    private const OPTION_KEY = 'extend_site_migrated_project_cmb_to_carbon';
    private const LOCK_KEY = 'extend_site_migrating_project_cmb_to_carbon';

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
            'post_type' => ProjectPostType::SLUG,
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);

        foreach ($post_ids as $post_id) {
            $migrated += self::migrate_project((int) $post_id);
        }

        update_option(self::OPTION_KEY, [
            'migrated_at' => current_time('mysql'),
            'post_count' => count($post_ids),
            'field_count' => $migrated,
        ], false);

        delete_transient(self::LOCK_KEY);
    }

    private static function migrate_project(int $post_id): int
    {
        $migrated = 0;

        $migrated += self::copy_media_gallery($post_id, 'paint_cmb_project_gallery', ProjectGalleryTab::GALLERY);
        $migrated += self::copy_image($post_id, 'paint_cmb_project_banner', ProjectGeneralTab::BANNER);
        $migrated += self::copy_scalar($post_id, 'paint_cmb_project_model', ProjectGeneralTab::MODEL);
        $migrated += self::copy_scalar($post_id, 'paint_cmb_project_mass', ProjectGeneralTab::MASS);
        $migrated += self::copy_scalar($post_id, 'paint_cmb_project_completion_time', ProjectGeneralTab::COMPLETION_TIME);
        $migrated += self::copy_scalar($post_id, 'paint_cmb_project_construction', ProjectGeneralTab::CONSTRUCTION);

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

    private static function copy_image(int $post_id, string $old_key, string $new_key): int
    {
        if (self::has_carbon_value($post_id, $new_key)) {
            return 0;
        }

        $image_id = self::attachment_id_from_cmb_file($post_id, $old_key);

        if (!$image_id) {
            return 0;
        }

        carbon_set_post_meta($post_id, $new_key, $image_id);

        return 1;
    }

    private static function copy_media_gallery(int $post_id, string $old_key, string $new_key): int
    {
        if (self::has_carbon_value($post_id, $new_key)) {
            return 0;
        }

        $gallery = self::get_first_non_empty_meta($post_id, $old_key);

        if (!is_array($gallery) || empty($gallery)) {
            return 0;
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

        $image_ids = array_values(array_unique(array_filter($image_ids)));

        if (empty($image_ids)) {
            return 0;
        }

        carbon_set_post_meta($post_id, $new_key, $image_ids);

        return 1;
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
