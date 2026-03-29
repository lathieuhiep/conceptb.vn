<?php

namespace ExtendSite\Admin\Fields\Pages\Default;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

class MenuTab implements FieldTabIF
{
    /**
     * Meta key prefix for Menu settings on Page.
     */
    private const KEY = 'es_page_menu_';
    private const STYLE = self::KEY . 'style';
    private const POSITION = self::KEY . 'position';

    /**
     * Define Carbon Fields for Menu tab.
     */
    public static function fields(): array
    {
        return [
            Field::make(
                'select',
                self::STYLE,
                esc_html__('Kiểu menu', 'extend-site')
            )
                ->add_options([
                    '' => esc_html__('Mặc định', 'extend-site'),
                    'v-1' => esc_html__('Kiểu 1', 'extend-site'),
                ])
                ->set_default_value(''),

            Field::make(
                'select',
                self::POSITION,
                esc_html__('Vị trí menu', 'extend-site')
            )
                ->add_options([
                    '' => esc_html__('Mặc định', 'extend-site'),
                    'static' => esc_html__('Static (mặc định)', 'extend-site'),
                    'relative' => esc_html__('Relative', 'extend-site'),
                    'absolute' => esc_html__('Absolute', 'extend-site'),
                    'fixed' => esc_html__('Fixed (dính màn hình)', 'extend-site'),
                    'sticky' => esc_html__('Sticky (cuộn tới thì dính)', 'extend-site'),
                ])
                ->set_default_value(''),
        ];
    }

    /**
     * Get Menu settings data for frontend usage.
     */
    public static function get_data(int $post_id): array
    {
        return [
            'style' => carbon_get_post_meta($post_id, self::STYLE),
            'position' => carbon_get_post_meta($post_id, self::POSITION),
        ];
    }
}