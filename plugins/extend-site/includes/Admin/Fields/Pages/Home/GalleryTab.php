<?php

namespace ExtendSite\Admin\Fields\Pages\Home;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class GalleryTab implements FieldTabIF
{

    private const KEY = 'es_home_page_gallery_tab_';
    private const ROWS = self::KEY . 'rows';

    /**
     * Define Carbon Fields.
     */
    public static function fields(): array
    {
        return [
            Field::make('complex', self::ROWS, esc_html__('Galleries', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->set_collapsed(true)
                ->add_fields(array(
                    Field::make('select', 'direction',
                        esc_html__('Chiều chạy', 'extend-site')
                    )->set_options([
                        'ltr' => esc_html__('Trái → Phải', 'extend-site'),
                        'rtl' => esc_html__('Phải → Trái', 'extend-site'),
                    ])->set_default_value('ltr'),

                    Field::make( 'media_gallery', 'gallery', esc_html__('Ảnh trong hàng', 'extend-site') )
                        ->set_type( array( 'image' ) )
                ))->set_header_template('Gallery <%- $_index + 1 %>')
        ];
    }

    /**
     * Get Partner tab data for frontend usage.
     */
    public static function get_data(int $post_id): array
    {
        return [
            'group_gallery' => carbon_get_post_meta($post_id, self::ROWS),
        ];
    }
}

