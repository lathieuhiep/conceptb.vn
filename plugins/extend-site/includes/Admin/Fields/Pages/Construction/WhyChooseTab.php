<?php
namespace ExtendSite\Admin\Fields\Pages\Construction;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class WhyChooseTab implements FieldTabIF
{
    private const KEY = 'es_construction_page_why_choose_tab_';
    private const TITLE = self::KEY . 'title';
    private const FEATURE_GROUP_TITLE = self::KEY . 'feature_group_title';
    private const FEATURES = self::KEY . 'features';
    private const COMMITMENTS = self::KEY . 'commitments';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề section', 'extend-site'))
                ->set_default_value('VÌ SAO CHỌN CONCEPTB?')
                ->set_width(50),

            Field::make('text', self::FEATURE_GROUP_TITLE, esc_html__('Tiêu đề nhóm lý do', 'extend-site'))
                ->set_default_value('1. THI CÔNG CHUYÊN NGHIỆP')
                ->set_width(50),

            Field::make('complex', self::FEATURES, esc_html__('Danh sách lý do chính', 'extend-site'))
                ->set_layout('tabbed-horizontal')
                ->add_fields([
                    Field::make('image', 'image', esc_html__('Ảnh', 'extend-site'))
                        ->set_width(33),
                    Field::make('text', 'title', esc_html__('Tiêu đề', 'extend-site'))
                        ->set_width(33),
                    Field::make('rich_text', 'description', esc_html__('Mô tả', 'extend-site'))
                        ->set_width(100),
                ])
                ->set_header_template('<%- title ? title : "' . esc_html__('Lý do', 'extend-site') . ' " + ($_index + 1) %>'),

            Field::make('complex', self::COMMITMENTS, esc_html__('Danh sách cam kết', 'extend-site'))
                ->set_layout('tabbed-horizontal')
                ->add_fields([
                    Field::make('text', 'title', esc_html__('Tiêu đề', 'extend-site'))
                        ->set_width(33),
                    Field::make('image', 'image', esc_html__('Ảnh', 'extend-site'))
                        ->set_width(33),
                    Field::make('rich_text', 'description', esc_html__('Mô tả', 'extend-site'))
                        ->set_width(100),
                ])
                ->set_header_template('<%- title ? title : "' . esc_html__('Cam kết', 'extend-site') . ' " + ($_index + 1) %>'),
        ];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'title' => trim((string) carbon_get_post_meta($post_id, self::TITLE)),
            'feature_group_title' => trim((string) carbon_get_post_meta($post_id, self::FEATURE_GROUP_TITLE)),
            'features' => carbon_get_post_meta($post_id, self::FEATURES),
            'commitments' => carbon_get_post_meta($post_id, self::COMMITMENTS),
        ];
    }
}
