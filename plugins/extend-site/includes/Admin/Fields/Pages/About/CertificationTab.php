<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class CertificationTab implements FieldTabIF
{
    private const KEY = 'es_about_page_certification_tab_';
    private const TITLE = self::KEY . 'title';
    private const IMAGES = self::KEY . 'images';

    public static function boot_admin_cleanup(): void
    {
        if (!is_admin()) {
            return;
        }

        add_action('admin_init', [self::class, 'clean_stale_gallery_meta']);
    }

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('ISO & CHỨNG NHẬN CHẤT LƯỢNG')
                ->set_width(50),

            Field::make('media_gallery', self::IMAGES, esc_html__('Thư viện ảnh chứng nhận', 'extend-site'))
                ->set_type( array( 'image' ) )
                ->set_width(50),
        ];
    }

    public static function get_data(int $post_id): array
    {
        $images = carbon_get_post_meta($post_id, self::IMAGES);

        return [
            'title' => trim((string)carbon_get_post_meta($post_id, self::TITLE)),
            'images' => self::valid_image_ids($images),
        ];
    }

    public static function clean_stale_gallery_meta(): void
    {
        if (!function_exists('carbon_get_post_meta') || !function_exists('carbon_set_post_meta')) {
            return;
        }

        $post_id = self::current_admin_post_id();

        if (!$post_id || !current_user_can('edit_post', $post_id)) {
            return;
        }

        if (get_page_template_slug($post_id) !== 'templates/about-us.php') {
            return;
        }

        $images = carbon_get_post_meta($post_id, self::IMAGES);
        $clean_images = self::valid_image_ids($images);
        $current_images = is_array($images) ? array_values(array_map('intval', $images)) : [];

        if ($clean_images !== $current_images) {
            carbon_set_post_meta($post_id, self::IMAGES, $clean_images);
        }
    }

    private static function current_admin_post_id(): int
    {
        if (isset($_GET['post'])) {
            return absint(wp_unslash($_GET['post']));
        }

        if (isset($_POST['post_ID'])) {
            return absint(wp_unslash($_POST['post_ID']));
        }

        return 0;
    }

    private static function valid_image_ids($images): array
    {
        if (!is_array($images)) {
            return [];
        }

        return array_values(array_filter(array_map('intval', $images), static function (int $image_id): bool {
            return $image_id > 0 && wp_attachment_is_image($image_id);
        }));
    }
}
