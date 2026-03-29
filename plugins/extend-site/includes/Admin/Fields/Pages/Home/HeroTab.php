<?php
namespace ExtendSite\Admin\Fields\Pages\Home;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;
use ExtendSite\Constants\ControlOptions;

defined('ABSPATH') || exit;

class HeroTab implements FieldTabIF
{
    private const KEY = 'es_home_page_hero_tab_';
    private const CAPTION = self::KEY . 'caption';
    private const HEADLINE = self::KEY . 'headline';
    private const HEADLINE_TAG = self::KEY . 'headline_tag';
    private const BUTTON_TEXT = self::KEY . 'button_text';
    private const BUTTON_LINK = self::KEY . 'button_link';
    private const IMAGE_BANNER = self::KEY . 'image_banner';

    /**
     * Define Carbon Fields for Hero tab.
     */
    public static function fields(): array
    {
        return [
            Field::make('text', self::CAPTION, esc_html__('Dòng chú thích (Caption)', 'paint'))
                ->set_default_value('CHỦ ĐỘNG NGUỒN LỰC')
                ->set_width(50),

            Field::make('text', self::HEADLINE, esc_html__('Tiêu đề chính (Headline)', 'paint'))
                ->set_default_value('Bứt phá tiến độ')
                ->set_width(50),

            Field::make('select', self::HEADLINE_TAG, esc_html__('Thẻ HTML tiêu đề', 'paint'))
                ->add_options(ControlOptions::heading_tags())
                ->set_default_value('h2')
                ->set_width(25),

            Field::make('text', self::BUTTON_TEXT, esc_html__('Chữ trên nút', 'paint'))
                ->set_default_value('Năng lực thi công')
                ->set_width(25),

            Field::make('text', self::BUTTON_LINK, esc_html__('Link nút', 'paint'))
                ->set_attribute('type', 'url')
                ->set_default_value('https://example.com')
                ->set_width(50),

            Field::make('image', self::IMAGE_BANNER, esc_html__('Ảnh nền', 'paint'))
                ->set_width(50),
        ];
    }

    /**
     * Get Hero tab data for frontend usage.
     */
    public static function get_data(int $post_id): array
    {
        return [
            'caption'   => carbon_get_post_meta($post_id, self::CAPTION),
            'headline'  => carbon_get_post_meta($post_id, self::HEADLINE),
            'tag'       => carbon_get_post_meta($post_id, self::HEADLINE_TAG) ?: 'h2',
            'button'    => [
                'text' => carbon_get_post_meta($post_id, self::BUTTON_TEXT),
                'link' => carbon_get_post_meta($post_id, self::BUTTON_LINK),
            ],
            'image_banner' => carbon_get_post_meta($post_id, self::IMAGE_BANNER)
        ];
    }
}