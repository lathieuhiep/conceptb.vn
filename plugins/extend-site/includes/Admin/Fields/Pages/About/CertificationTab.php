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

            Field::make('complex', self::IMAGES, esc_html__('Thư viện ảnh chứng nhận', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('image', 'image', esc_html__('Chọn ảnh', 'extend-site'))
                        ->set_width(50),

                    Field::make('text', 'title', esc_html__('Tiêu đề ảnh', 'extend-site'))
                        ->set_width(50),
                ])
                ->set_header_template('
                    <% if (title) { %>
                        <%- title %>
                    <% } else { %>
                        ' . esc_html__('Ảnh', 'extend-site') . ' <%- $_index + 1 %>
                    <% } %>
                '),
        ];
    }

    public static function get_data(int $post_id): array
    {
        $images = self::normalize_gallery(carbon_get_post_meta($post_id, self::IMAGES));

        return [
            'title' => trim((string) carbon_get_post_meta($post_id, self::TITLE)),
            'images' => $images,
            'image_ids' => array_column($images, 'image_id'),
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
        $clean_images = self::storage_gallery(self::normalize_gallery($images));

        if (self::needs_gallery_cleanup($images, $clean_images)) {
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

    private static function normalize_gallery($images): array
    {
        if (!is_array($images)) {
            return [];
        }

        $normalized = [];

        foreach ($images as $item) {
            $image_id = 0;
            $title = '';

            if (is_numeric($item)) {
                $image_id = (int) $item;
                $title = $image_id > 0 ? trim((string) get_the_title($image_id)) : '';
            } elseif (is_array($item)) {
                if (!empty($item['image'])) {
                    $image_id = is_numeric($item['image'])
                        ? (int) $item['image']
                        : attachment_url_to_postid((string) $item['image']);
                }

                if (!$image_id && !empty($item['image_id'])) {
                    $image_id = (int) $item['image_id'];
                }

                $title = isset($item['title']) ? trim((string) $item['title']) : '';
            }

            if ($image_id <= 0 || !wp_attachment_is_image($image_id)) {
                continue;
            }

            $normalized[] = [
                'image' => $image_id,
                'image_id' => $image_id,
                'title' => $title,
            ];
        }

        return $normalized;
    }

    private static function storage_gallery(array $images): array
    {
        return array_map(static function (array $item): array {
            return [
                'image' => (int) $item['image_id'],
                'title' => (string) $item['title'],
            ];
        }, $images);
    }

    private static function needs_gallery_cleanup($images, array $clean_images): bool
    {
        if (!is_array($images)) {
            return !empty($clean_images);
        }

        if (count($images) !== count($clean_images)) {
            return true;
        }

        foreach ($images as $item) {
            if (!is_array($item) || (empty($item['image']) && empty($item['image_id']))) {
                return true;
            }
        }

        return $clean_images !== self::storage_gallery(self::normalize_gallery($images));
    }
}
