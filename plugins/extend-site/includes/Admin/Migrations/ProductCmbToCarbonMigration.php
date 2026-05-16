<?php

namespace ExtendSite\Admin\Migrations;

use ExtendSite\Admin\Fields\Product\ProductConstructionTab;
use ExtendSite\Admin\Fields\Product\ProductGalleryTab;
use ExtendSite\Admin\Fields\Product\ProductGeneralTab;
use ExtendSite\Admin\Fields\Product\ProductMediaTab;
use ExtendSite\PostType\ProductPostType;

defined('ABSPATH') || exit;

class ProductCmbToCarbonMigration
{
    private const OPTION_KEY = 'extend_site_migrated_product_cmb_to_carbon';
    private const LOCK_KEY = 'extend_site_migrating_product_cmb_to_carbon';

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
        $product_ids = get_posts([
            'post_type' => ProductPostType::SLUG,
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);

        foreach ($product_ids as $post_id) {
            $migrated += self::migrate_product((int) $post_id);
        }

        if (!$has_run) {
            update_option(self::OPTION_KEY, [
                'migrated_at' => current_time('mysql'),
                'product_count' => count($product_ids),
                'field_count' => $migrated,
            ], false);
        } else {
            update_option(self::OPTION_KEY . '_last_sync', [
                'synced_at' => current_time('mysql'),
                'product_count' => count($product_ids),
                'field_count' => $migrated,
            ], false);
        }

        delete_transient(self::LOCK_KEY);
    }

    private static function migrate_product(int $post_id): int
    {
        $migrated = 0;

        $migrated += self::copy_scalar(
            $post_id,
            'paint_cmb_product_code',
            ProductGeneralTab::CODE
        );

        $migrated += self::copy_scalar(
            $post_id,
            'paint_cmb_options_product_color',
            ProductGeneralTab::COLOR
        );

        $migrated += self::copy_image(
            $post_id,
            'paint_cmb_product_image_feature_hover',
            ProductMediaTab::IMAGE_HOVER
        );

        $migrated += self::copy_media_gallery(
            $post_id,
            'paint_cmb_product_image_gallery',
            ProductMediaTab::IMAGE_GALLERY
        );

        $migrated += self::copy_real_gallery(
            $post_id,
            'paint_cmb_product_gallery',
            ProductGalleryTab::GALLERY
        );

        $migrated += self::copy_complex_array(
            $post_id,
            'paint_cmb_product_construction_process',
            ProductConstructionTab::CONSTRUCTION_PROCESS
        );

        return $migrated;
    }

    private static function copy_scalar(int $post_id, string $old_key, string $new_key): int
    {
        if (self::has_carbon_value($post_id, $new_key)) {
            return 0;
        }

        $value = get_post_meta($post_id, $old_key, true);

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

        $old_gallery = get_post_meta($post_id, $old_key, true);

        if (!is_array($old_gallery) || empty($old_gallery)) {
            return 0;
        }

        $image_ids = [];

        foreach ($old_gallery as $id => $url) {
            $image_id = is_numeric($id) ? (int) $id : 0;

            if (!$image_id && is_string($url)) {
                $image_id = attachment_url_to_postid($url);
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

    private static function copy_real_gallery(int $post_id, string $old_key, string $new_key): int
    {
        if (self::has_carbon_value($post_id, $new_key)) {
            return 0;
        }

        $old_rows = get_post_meta($post_id, $old_key, true);

        if (!is_array($old_rows) || empty($old_rows)) {
            return 0;
        }

        $new_rows = [];

        foreach ($old_rows as $row) {
            if (!is_array($row)) {
                continue;
            }

            $image_id = 0;

            if (!empty($row['image_id'])) {
                $image_id = (int) $row['image_id'];
            }

            if (!$image_id && !empty($row['image']) && is_string($row['image'])) {
                $image_id = attachment_url_to_postid($row['image']);
            }

            $new_rows[] = [
                'style' => !empty($row['style']) ? (string) $row['style'] : 'normal',
                'image' => $image_id,
            ];
        }

        if (empty($new_rows)) {
            return 0;
        }

        carbon_set_post_meta($post_id, $new_key, $new_rows);

        return 1;
    }

    private static function copy_complex_array(int $post_id, string $old_key, string $new_key): int
    {
        if (self::has_carbon_value($post_id, $new_key)) {
            return 0;
        }

        $rows = get_post_meta($post_id, $old_key, true);

        if (!is_array($rows) || empty($rows)) {
            return 0;
        }

        carbon_set_post_meta($post_id, $new_key, self::with_default_complex_group($rows));

        return 1;
    }

    private static function with_default_complex_group(array $rows): array
    {
        foreach ($rows as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            if (!isset($row['_type'])) {
                $rows[$index]['_type'] = '_';
            }
        }

        return $rows;
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

    private static function has_carbon_value(int $post_id, string $key): bool
    {
        $value = carbon_get_post_meta($post_id, $key);

        if (is_array($value)) {
            return !empty($value);
        }

        return $value !== '' && $value !== null;
    }
}
