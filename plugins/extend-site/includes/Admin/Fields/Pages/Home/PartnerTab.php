<?php
namespace ExtendSite\Admin\Fields\Pages\Home;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class PartnerTab implements FieldTabIF {

    private const KEY = 'es_home_page_partner_tab_';
    private const GALLERY = self::KEY . 'gallery';

    /**
     * Define Carbon Fields for Partner tab.
     */
    public static function fields(): array {
        return [
            Field::make( 'media_gallery', self::GALLERY, esc_html__('Logo đối tác', 'extend-site') )
                ->set_type( array( 'image' ) )
        ];
    }

    /**
     * Get Partner tab data for frontend usage.
     */
    public static function get_data(int $post_id): array
    {
        return [
            'gallery' => carbon_get_post_meta($post_id, self::GALLERY),
        ];
    }
}

